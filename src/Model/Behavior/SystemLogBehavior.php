<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\Datasource\EntityInterface;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class SystemLogBehavior extends Behavior
{
    /**
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     */
    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $action = $entity->isNew() ? 'insert' : 'update';
        $this->_logAction($action, $entity);
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     */
    public function afterDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->_logAction('delete', $entity);
    }

    /**
     * @param string $action
     * @param \Cake\Datasource\EntityInterface $entity
     */
    protected function _logAction(string $action, EntityInterface $entity)
    {
        // Don't log the system_logs table itself
        if ($this->_table->getAlias() === 'SystemLogs') {
            return;
        }

        $userId = Configure::read('CurrentUser');
        $data = $entity->toArray();
        if (isset($data['password'])) {
            unset($data['password']);
        }

        $logData = [
            'user_id' => $userId,
            'action' => $action,
            'model' => $this->_table->getAlias(),
            'entity_id' => $entity->get($this->_table->getPrimaryKey()),
            'data' => json_encode($data),
            'ip_address' => env('REMOTE_ADDR'),
            'user_agent' => env('HTTP_USER_AGENT'),
            'created' => date('Y-m-d H:i:s'),
        ];

        $systemLogsTable = TableRegistry::getTableLocator()->get('SystemLogs');
        $logEntity = $systemLogsTable->newEntity($logData);
        $systemLogsTable->save($logEntity);
    }
}
