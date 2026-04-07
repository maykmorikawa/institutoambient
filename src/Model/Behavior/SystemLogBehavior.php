<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\Datasource\EntityInterface;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class SystemLogBehavior extends Behavior
{
    /**
     * Grava log após criar ou atualizar um registro.
     */
    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $action = $entity->isNew() ? 'insert' : 'update';
        // Se for um update mas nada mudou, não salva nada
        if ($action === 'update' && empty($entity->getDirty())) {
            return;
        }
        $this->_logAction($action, $entity);
    }

    /**
     * Grava log após excluir (ou soft-delete) um registro.
     */
    public function afterDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->_logAction('delete', $entity);
    }

    /**
     * Grava a ação na tabela system_logs.
     */
    protected function _logAction(string $action, EntityInterface $entity): void
    {
        // Evita loop infinito: não loga a própria tabela de logs
        if ($this->_table->getAlias() === 'SystemLogs') {
            return;
        }

        $userId = Configure::read('CurrentUser');

        // Captura apenas campos que mudaram (ou todos se for novo)
        if ($entity->isNew()) {
            $data = $entity->toArray();
        } else {
            $data = array_intersect_key($entity->toArray(), array_flip($entity->getDirty()));
        }

        // Remove senha do log por segurança
        unset($data['password'], $data['password_confirm']);

        // Tenta capturar dados do request (IP e Browser)
        $request = Router::getRequest();
        $ip = $request ? $request->clientIp() : '127.0.0.1';
        $agent = $request ? $request->getHeaderLine('User-Agent') : 'CLI/System';

        $logData = [
            'user_id'      => $userId,
            'action'       => $action,
            'target_model' => $this->_table->getAlias(),
            'target_id'    => (string) $entity->get($this->_table->getPrimaryKey()),
            'data_changes' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'ip_address'   => $ip,
            'user_agent'   => substr($agent, 0, 255),
            'created'      => date('Y-m-d H:i:s'),
        ];

        try {
            $logsTable  = TableRegistry::getTableLocator()->get('SystemLogs');
            $logEntity  = $logsTable->newEntity($logData, ['validate' => false]);
            $logsTable->save($logEntity);
        } catch (\Throwable $e) {
            // Silencia erros de log para não interromper a operação principal
        }
    }
}
