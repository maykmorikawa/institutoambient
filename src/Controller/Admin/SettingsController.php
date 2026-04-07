<?php
// src/Controller/Admin/SettingsController.php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Text;
use Cake\ORM\TableRegistry;

/**
 * Settings Controller (Admin)
 */
class SettingsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Lista todas as configurações.
     */
    public function index()
    {
        $settings = $this->paginate($this->Settings);
        $this->set(compact('settings'));
    }

    /**
     * Edita configurações do sistema.
     */
    public function edit($key = null)
    {
        $configKeys = [
            'certificate_bg_page1'      => ['label' => 'Fundo do certificado - Página 1', 'type' => 'image'],
            'certificate_bg_page2'      => ['label' => 'Fundo do certificado - Página 2', 'type' => 'image'],
            'logo_instituto_ambient_ia' => ['label' => 'Logo Instituto Ambient IA',        'type' => 'image'],
            'logo_equatorial_energia'   => ['label' => 'Logo Equatorial Energia',          'type' => 'image'],
            'logo_comdac'               => ['label' => 'Logo COMDAC',                      'type' => 'image'],
        ];

        if ($key !== null) {
            if (!isset($configKeys[$key])) {
                throw new NotFoundException("Chave '{$key}' não encontrada.");
            }
            $setting = $this->Settings->findOrCreate(
                ['key_name' => $key],
                function ($entity) use ($configKeys, $key) {
                    $entity->type        = $configKeys[$key]['type'];
                    $entity->description = $configKeys[$key]['label'];
                }
            );
            if ($this->request->is(['patch', 'post', 'put'])) {
                $data = $this->request->getData();
                if ($setting->type === 'image' && !empty($data['value_upload'])) {
                    $file = $data['value_upload'];
                    if ($file->getError() === 0) {
                        $filename = Text::uuid() . '-' . $file->getClientFilename();
                        $file->moveTo(WWW_ROOT . 'img/uploads/' . $filename);
                        $setting->value = 'uploads/' . $filename;
                    }
                }
                if ($this->Settings->save($setting)) {
                    $this->Flash->success(__('Configuração atualizada com sucesso.'));
                    return $this->redirect(['action' => 'edit', $key]);
                }
                $this->Flash->error(__('Erro ao salvar configuração.'));
            }
            $this->set(compact('setting', 'key'));
            $this->render('edit_single');
        } else {
            $settings = [];
            foreach ($configKeys as $k => $details) {
                $settings[$k] = $this->Settings->findOrCreate(
                    ['key_name' => $k],
                    function ($entity) use ($details) {
                        $entity->type        = $details['type'];
                        $entity->description = $details['label'];
                    }
                );
            }
            if ($this->request->is(['patch', 'post', 'put'])) {
                $data = $this->request->getData();
                foreach ($settings as $k => $setting) {
                    if ($setting->type === 'image' && !empty($data[$k . '_upload'])) {
                        $file = $data[$k . '_upload'];
                        if ($file->getError() === 0) {
                            $filename = Text::uuid() . '-' . $file->getClientFilename();
                            $file->moveTo(WWW_ROOT . 'img/uploads/' . $filename);
                            $setting->value = 'uploads/' . $filename;
                        }
                    }
                }
                if ($this->Settings->saveMany($settings)) {
                    $this->Flash->success(__('Todas as configurações foram atualizadas.'));
                    return $this->redirect(['action' => 'edit']);
                }
                $this->Flash->error(__('Erro ao salvar as configurações.'));
            }
            $this->set(compact('settings', 'configKeys'));
            $this->render('edit_all');
        }
    }

    // ─────────────────────────────────────────────
    //  LOGS DO SISTEMA
    // ─────────────────────────────────────────────

    public function logs()
    {
        $systemLogs = TableRegistry::getTableLocator()->get('SystemLogs');

        $model  = $this->request->getQuery('model');
        $action = $this->request->getQuery('action');
        $userId = $this->request->getQuery('user_id');

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

    // ─────────────────────────────────────────────
    //  LIXEIRA (SOFT DELETE)
    // ─────────────────────────────────────────────

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

    // ─────────────────────────────────────────────
    //  RESTAURAR DA LIXEIRA
    // ─────────────────────────────────────────────

    public function restore($table = null, $id = null)
    {
        $this->request->allowMethod(['post']);

        $allowedTables = [
            'Posts', 'Users', 'Alunos',
            'Projetos', 'Atividades', 'Inscricoes',
            'Categories', 'Tags',
        ];

        if (!in_array($table, $allowedTables)) {
            $this->Flash->error('Tabela inválida.');
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
