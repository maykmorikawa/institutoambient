<?php
// src/Controller/Admin/SettingsController.php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Filesystem\Utility\File;   // CORREÇÃO: Namespace correto para File
use Cake\Filesystem\Utility\Folder; // CORREÇÃO: Namespace correto para Folder
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Text;


/**
 * Settings Controller
 *
 * Este controller é responsável por gerenciar as configurações gerais do sistema,
 * incluindo o upload de imagens e outras variáveis configuráveis.
 *
 * @property \App\Model\Table\SettingsTable $Settings
 * @property \App\Controller\Component\FlashComponent $Flash
 *
 * @method \App\Model\Entity\Setting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SettingsController extends AppController
{
    /**
     * Inicializa o controller.
     * Este método é chamado antes de qualquer action do controller.
     */
    public function initialize(): void
    {
        parent::initialize();
        // Você pode querer permitir acesso não autenticado a algumas configurações,
        // mas para o painel admin, a autenticação é geralmente necessária.
        // Exemplo: $this->Authentication->allowUnauthenticated(['index', 'view']);
    }

    /**
     * Método Index
     * Lista todas as configurações existentes no sistema, paginadas.
     *
     * @return \Cake\Http\Response|null|void Renderiza a view com a lista de configurações.
     */
    public function index()
    {
        // Pagina as configurações da tabela Settings.
        $settings = $this->paginate($this->Settings);

        // Passa as configurações paginadas para a view.
        $this->set(compact('settings'));
    }

    /**
     * Método Edit
     * Edita as configurações do sistema, incluindo o upload de arquivos de imagem.
     *
     * Este método lida com um formulário que permite ao usuário atualizar
     * várias configurações (textos, imagens) de uma só vez.
     *
     * @return \Cake\Http\Response|null|void Redireciona em caso de sucesso na edição,
     * ou renderiza a view do formulário caso contrário.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando um registro não for encontrado (embora findOrCreate minimize isso).
     */
    public function edit($key = null)
    {
        $configKeys = [
            'certificate_bg_page1' => ['label' => 'Fundo do certificado - Página 1', 'type' => 'image'],
            'certificate_bg_page2' => ['label' => 'Fundo do certificado - Página 2', 'type' => 'image'],
            'logo_instituto_ambient_ia' => ['label' => 'Logo Instituto Ambient IA', 'type' => 'image'],
            'logo_equatorial_energia' => ['label' => 'Logo Equatorial Energia', 'type' => 'image'],
            'logo_comdac' => ['label' => 'Logo COMDAC', 'type' => 'image'],
            // você pode adicionar mais chaves aqui...
        ];

        if ($key !== null) {
            // ✅ EDIÇÃO DE UMA CHAVE ESPECÍFICA
            if (!isset($configKeys[$key])) {
                throw new NotFoundException("Chave '{$key}' não encontrada.");
            }

            $setting = $this->Settings->findOrCreate(
                ['key_name' => $key],
                function ($entity) use ($configKeys, $key) {
                    $entity->type = $configKeys[$key]['type'];
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
            $this->render('edit_single'); // 🧠 crie um template separado para uma única chave

        } else {
            // ✅ EDIÇÃO EM LOTE
            $settings = [];

            foreach ($configKeys as $k => $details) {
                $setting = $this->Settings->findOrCreate(
                    ['key_name' => $k],
                    function ($entity) use ($details) {
                        $entity->type = $details['type'];
                        $entity->description = $details['label'];
                    }
                );
                $settings[$k] = $setting;
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
                    $this->Flash->success(__('Todas as configurações foram atualizadas com sucesso.'));
                    return $this->redirect(['action' => 'edit']);
                }
                $this->Flash->error(__('Erro ao salvar as configurações.'));
            }

            $this->set(compact('settings', 'configKeys'));
            $this->render('edit_all'); // 🧠 crie um template separado para editar todos
        }
    }

}
