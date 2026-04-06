<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query\SelectQuery;

class SoftDeleteBehavior extends Behavior
{
    /**
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param \ArrayObject $options
     * @param bool $primary
     */
    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary)
    {
        // Se a opção withDeleted for passada, não filtra pelos excluídos (útil para Lixeiras)
        if (isset($options['withDeleted']) && $options['withDeleted']) {
            return;
        }

        if ($this->_table->getSchema()->hasColumn('deleted')) {
            $alias = $this->_table->getAlias();
            $query->where([$alias . '.deleted IS' => null]);
        }
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     */
    public function beforeDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if (!$this->_table->getSchema()->hasColumn('deleted')) {
            return true;
        }

        $entity->set('deleted', date('Y-m-d H:i:s'));
        
        // Salva a entidade com a data de exclusão
        if ($this->_table->save($entity)) {
            // Emite o evento afterDelete para acionar o Log se o Soft Delete funcionar
            $afterDeleteEvent = new \Cake\Event\Event('Model.afterDelete', $this->_table, [
                'entity' => $entity,
                'options' => $options
            ]);
            $this->_table->getEventManager()->dispatch($afterDeleteEvent);
        }

        // Para a execução do delete original do banco de dados
        $event->stopPropagation();
        return false;
    }

    /**
     * Encontra registros incluindo os que foram apagados
     */
    public function findWithDeleted(SelectQuery $query, array $options)
    {
        return $query->applyOptions(['withDeleted' => true]);
    }
}
