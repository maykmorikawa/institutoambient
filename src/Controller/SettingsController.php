<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Settings Controller
 *
 * @property \App\Model\Table\SettingsTable $Settings
 */
class SettingsController extends AppController
{
    public function index()
    {
        $query = $this->Settings->find();
        $settings = $this->paginate($query);
        $this->set(compact('settings'));
    }

    public function view($id = null)
    {
        $setting = $this->Settings->get($id, contain: []);
        $this->set(compact('setting'));
    }

    public function add()
    {
        $setting = $this->Settings->newEmptyEntity();
        if ($this->request->is('post')) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The setting has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The setting could not be saved. Please, try again.'));
        }
        $this->set(compact('setting'));
    }

    public function edit($id = null)
    {
        $setting = $this->Settings->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The setting has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The setting could not be saved. Please, try again.'));
        }
        $this->set(compact('setting'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $setting = $this->Settings->get($id);
        if ($this->Settings->delete($setting)) {
            $this->Flash->success(__('The setting has been deleted.'));
        } else {
            $this->Flash->error(__('The setting could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * System Logs - Visualizacao de todos os logs do sistema
     */
    public function logs()
    {
        $systemLogs = TableRegistry::getTableLocator()->get('SystemLogs');
        $systemLogs->belongsTo('Users', ['foreignKey' => 'user_id']);

        $model   = $this->request->getQuery('model');
        $action  = $this->request->getQuery('action');
        $userId  = $this->request->getQuery('user_id');

        $conditions = [];
        if (!empty($model))  { $conditions['SystemLogs.target_model'] = $model; }
        if (!empty($action)) { $conditions['SystemLogs.action']       = $action; }
        if (!empty($userId)) { $conditions['SystemLogs.user_id']      = $userId; }

        $this->paginate = [
            'limit'      => 30,
            'order'      => ['SystemLogs.created' => 'DESC'],
            'contain'    => ['Users'],
            'conditions' => $conditions,
        ];

        $logs = $this->paginate($systemLogs);

        $models = $systemLogs->find()
            ->select(['target_model'])
            ->distinct(['target_model'])
            ->orderBy(['target_model' => 'ASC'])
            ->all()
            ->extract('target_model')
            ->toArray();

        $users = TableRegistry::getTableLocator()->get('Users')
            ->find('list', keyField: 'id', valueField: 'email')
            ->orderBy(['email' => 'ASC'])
            ->toArray();

        $this->set(compact('logs', 'models', 'users'));
    }

    /**
     * Lixeira - exibe todos os registros apagados (soft deleted)
     */
    public function trash()
    {
        $tables = [
            'Posts', 'Users', 'Alunos',
            'Projetos', 'Atividades', 'Inscricoes',
            'Categories', 'Tags',
        ];

        $tableFilter = $this->request->getQuery('table') ?? 'Posts';
        $trashItems  = [];
        $hasTrash    = false;

        if (in_array($tableFilter, $tables)) {
            $tableObj = TableRegistry::getTableLocator()->get($tableFilter);
            if ($tableObj->getSchema()->hasColumn('deleted_at')) {
                $hasTrash = true;
                $this->paginate = [
                    'limit'      => 20,
                    'order'      => [$tableFilter . '.deleted_at' => 'DESC'],
                    'conditions' => [$tableFilter . '.deleted_at IS NOT' => null],
                ];
                $trashItems = $this->paginate($tableObj->find('withDeleted'));
            }
        }

        $this->set(compact('trashItems', 'tables', 'tableFilter', 'hasTrash'));
    }

    /**
     * Restaurar registro da lixeira
     */
    public function restore($table = null, $id = null)
    {
        $this->request->allowMethod(['post']);

        $allowedTables = [
            'Posts', 'Users', 'Alunos',
            'Projetos', 'Atividades', 'Inscricoes',
            'Categories', 'Tags',
        ];

        if (!in_array($table, $allowedTables)) {
            $this->Flash->error('Tabela inválida para restauração.');
            return $this->redirect(['action' => 'trash']);
        }

        $tableObj = TableRegistry::getTableLocator()->get($table);
        $entity   = $tableObj->find('withDeleted')
            ->where([$table . '.id' => $id])
            ->firstOrFail();

        $entity->set('deleted_at', null);
        if ($tableObj->save($entity)) {
            $this->Flash->success('Registro restaurado com sucesso!');
        } else {
            $this->Flash->error('Não foi possível restaurar o registro.');
        }

        return $this->redirect(['action' => 'trash', '?' => ['table' => $table]]);
    }
}
