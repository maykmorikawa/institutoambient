<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query\SelectQuery;

class SoftDeleteBehavior extends Behavior
{
    /**
     * Filtra automaticamente registros com deleted_at preenchido nas buscas normais.
     */
    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary)
    {
        if (isset($options['withDeleted']) && $options['withDeleted']) {
            return;
        }

        if ($this->_table->getSchema()->hasColumn('deleted_at')) {
            $alias = $this->_table->getAlias();
            $query->where([$alias . '.deleted_at IS' => null]);
        }
    }

    /**
     * Intercepta o delete real e substitui por um soft delete (preenche deleted_at).
     */
    public function beforeDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if (!$this->_table->getSchema()->hasColumn('deleted_at')) {
            return true;
        }

        $entity->set('deleted_at', date('Y-m-d H:i:s'));

        if ($this->_table->save($entity)) {
            // Dispara afterDelete manualmente para o log ser registrado
            $afterDeleteEvent = new Event('Model.afterDelete', $this->_table, [
                'entity'  => $entity,
                'options' => $options,
            ]);
            $this->_table->getEventManager()->dispatch($afterDeleteEvent);
        }

        // Impede o DELETE real no banco
        $event->stopPropagation();
        return false;
    }

    /**
     * Finder especial para buscar inclusive registros da lixeira.
     */
    public function findWithDeleted(SelectQuery $query, array $options): SelectQuery
    {
        return $query->applyOptions(['withDeleted' => true]);
    }

    /**
     * Método centralizado para realizar a exclusão lógica (Soft Delete).
     * 
     * @param \Cake\Datasource\EntityInterface $entity Entidade a ser excluída logicamente.
     * @return bool Sucesso ou falha na operação.
     */
    public function softDelete(EntityInterface $entity): bool
    {
        if (!$this->_table->getSchema()->hasColumn('deleted_at')) {
            throw new \RuntimeException(sprintf(
                'A tabela "%s" não possui a coluna "deleted_at" necessária para Soft Delete.',
                $this->_table->getAlias()
            ));
        }

        $entity->set('deleted_at', date('Y-m-d H:i:s'));

        // Salva a alteração diretamente sem disparar a exclusão física.
        if ($this->_table->save($entity)) {
            // Dispara afterDelete manualmente para o SystemLog poder registrar a ação.
            $afterDeleteEvent = new Event('Model.afterDelete', $this->_table, [
                'entity'  => $entity,
                'options' => new ArrayObject(),
            ]);
            $this->_table->getEventManager()->dispatch($afterDeleteEvent);

            return true;
        }

        return false;
    }
}
