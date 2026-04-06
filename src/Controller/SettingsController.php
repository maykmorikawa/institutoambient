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
        if (!empty($model))  { $conditions['SystemLogs.model']   = $model; }
        if (!empty($action)) { $conditions['SystemLogs.action']  = $action; }
        if (!empty($userId)) { $conditions['SystemLogs.user_id'] = $userId; }

        $this->paginate = [
            'limit'      => 30,
            'order'      => ['SystemLogs.created' => 'DESC'],
            'contain'    => ['Users'],
            'conditions' => $conditions,
        ];

        $logs = $this->paginate($systemLogs);

        $models = $systemLogs->find()
            ->select(['model'])
            ->distinct(['model'])
            ->orderBy(['model' => 'ASC'])
            ->all()
            ->extract('model')
            ->toArray();

        $users = TableRegistry::getTableLocator()->get('Users')
            ->find('list', keyField: 'id', valueField: 'name')
            ->orderBy(['name' => 'ASC'])
            ->toArray();

        $this->set(compact('logs', 'models', 'users'));
    }

    /**
     * Lixeira - exibe todos os registros apagados (soft deleted)
     */
    public function trash()
    {
        $tables = [
            'Alunos', 'Students', 'Users', 'Profiles',
            'Projetos', 'Atividades', 'Posts',
            'Categories', 'Tags', 'Comments',
            'Inscricoes', 'Presencas', 'Certificados',
            'Contacts', 'Enderecos',
        ];

        $tableFilter = $this->request->getQuery('table') ?? 'Users';
        $trashItems  = [];

        if (in_array($tableFilter, $tables)) {
            $tableObj = TableRegistry::getTableLocator()->get($tableFilter);
            if ($tableObj->getSchema()->hasColumn('deleted')) {
                $this->paginate = [
                    'limit'      => 20,
                    'order'      => [$tableFilter . '.deleted' => 'DESC'],
                    'conditions' => [$tableFilter . '.deleted IS NOT' => null],
                ];
                $trashItems = $this->paginate($tableObj->find('withDeleted'));
            }
        }

        $this->set(compact('trashItems', 'tables', 'tableFilter'));
    }

    /**
     * Restaurar registro da lixeira
     */
    public function restore($table = null, $id = null)
    {
        $this->request->allowMethod(['post']);

        $allowedTables = [
            'Alunos', 'Students', 'Users', 'Profiles',
            'Projetos', 'Atividades', 'Posts',
            'Categories', 'Tags', 'Comments',
            'Inscricoes', 'Presencas', 'Certificados',
            'Contacts', 'Enderecos',
        ];

        if (!in_array($table, $allowedTables)) {
            $this->Flash->error('Tabela invalida.');
            return $this->redirect(['action' => 'trash']);
        }

        $tableObj = TableRegistry::getTableLocator()->get($table);
        $entity   = $tableObj->find('withDeleted')
            ->where([$table . '.id' => $id])
            ->firstOrFail();

        $entity->set('deleted', null);
        if ($tableObj->save($entity)) {
            $this->Flash->success('Registro restaurado com sucesso!');
        } else {
            $this->Flash->error('Nao foi possivel restaurar o registro.');
        }

        return $this->redirect(['action' => 'trash', '?' => ['table' => $table]]);
    }
}
