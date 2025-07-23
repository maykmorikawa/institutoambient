<?php
// src/Controller/Admin/SettingsController.php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Filesystem\Utility\File;   // CORREÇÃO: Namespace correto para File
use Cake\Filesystem\Utility\Folder; // CORREÇÃO: Namespace correto para Folder

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
    public function edit()
    {
        // Define as chaves das configurações que queremos gerenciar, seus tipos e descrições.
        // 'path' é o diretório de upload relativo a WWW_ROOT (webroot/).
        $configKeys = [
            'certificate_bg_page1' => ['type' => 'image', 'description' => 'Imagem de fundo da Página 1 do Certificado', 'path' => 'img/backgrounds/'],
            'certificate_bg_page2' => ['type' => 'image', 'description' => 'Imagem de fundo da Página 2 do Certificado', 'path' => 'img/backgrounds/'],
            'logo_instituto_ambient_ia' => ['type' => 'image', 'description' => 'Logo do Instituto Ambiental (selo dourado)', 'path' => 'img/logos/'],
            'logo_equatorial_energia' => ['type' => 'image', 'description' => 'Logo Equatorial Energia', 'path' => 'img/logos/'],
            'logo_comdac' => ['type' => 'image', 'description' => 'Logo COMDAC', 'path' => 'img/logos/'],
            'logo_instituto_ambient_texto' => ['type' => 'image', 'description' => 'Logo Instituto Ambient (texto)', 'path' => 'img/logos/'],
            'logo_trabalho_lado_lado' => ['type' => 'image', 'description' => 'Logo Trabalho Lado a Lado', 'path' => 'img/logos/'],
            // Exemplo de uma configuração de texto/string:
            'carga_horaria_padrao_aula' => ['type' => 'string', 'description' => 'Carga horária padrão por aula (em horas)'],
            'texto_rodape_certificado' => ['type' => 'text', 'description' => 'Texto do rodapé do certificado'],
        ];

        // Carrega as configurações existentes do banco de dados ou cria entidades vazias se não existirem.
        $settings = [];
        foreach ($configKeys as $key => $details) {
            $setting = $this->Settings->findOrCreate(['key_name' => $key], function (\App\Model\Entity\Setting $entity) use ($key, $details) {
                $entity->key_name = $key;
                $entity->type = $details['type'];
                $entity->description = $details['description'];
            });
            $settings[$key] = $setting;
        }

        // Processa o envio do formulário (requisições POST ou PUT).
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData(); // Obtém todos os dados enviados pelo formulário.
            $entitiesToSave = []; // Array para armazenar as entidades de configuração a serem salvas/atualizadas.

            foreach ($configKeys as $key => $details) {
                $settingEntity = $settings[$key]; // Pega a entidade existente ou recém-criada para esta chave.

                if ($details['type'] === 'image') {
                    // Lida com o upload de imagem.
                    // O nome do campo de arquivo no formulário será $key . '_file'.
                    $uploadedFile = $data[$key . '_file'] ?? null;

                    // Verifica se um arquivo foi enviado e se não houve erros.
                    if ($uploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {
                        // Gera um nome de arquivo único para evitar colisões.
                        $filename = time() . '_' . $uploadedFile->getClientFilename();
                        $targetPath = WWW_ROOT . $details['path'] . $filename; // Caminho completo no servidor.

                        // Garante que o diretório de destino exista, criando-o se necessário.
                        $folder = new Folder(WWW_ROOT . $details['path'], true, 0755);

                        try {
                            // Move o arquivo enviado para o diretório de destino.
                            $uploadedFile->moveTo($targetPath);

                            // Se já existia um arquivo antigo para esta configuração, tenta deletá-lo.
                            if (!empty($settingEntity->value) && file_exists(WWW_ROOT . $details['path'] . $settingEntity->value)) {
                                unlink(WWW_ROOT . $details['path'] . $settingEntity->value);
                            }
                            // Salva apenas o nome do arquivo no campo 'value' da entidade.
                            $settingEntity->value = $filename;
                            $entitiesToSave[] = $settingEntity; // Adiciona à lista para salvamento em massa.
                            $this->Flash->success(sprintf(__('Imagem "%s" carregada com sucesso.'), $details['description']));
                        } catch (\Exception $e) {
                            // Em caso de erro no upload, exibe uma mensagem.
                            $this->Flash->error(sprintf(__('Erro ao carregar a imagem "%s": %s'), $details['description'], $e->getMessage()));
                        }
                    } else if ($uploadedFile && $uploadedFile->getError() !== UPLOAD_ERR_NO_FILE) {
                        // Lida com outros erros de upload (ex: tamanho máximo excedido).
                        $this->Flash->error(sprintf(__('Erro no upload da imagem "%s": Código de erro %s.'), $details['description'], $uploadedFile->getError()));
                    }
                } else {
                    // Lida com outros tipos de configuração (string, text).
                    $settingEntity->value = $data[$key] ?? null;
                    $entitiesToSave[] = $settingEntity; // Adiciona à lista para salvamento em massa.
                }
            }

            // Salva todas as entidades de configuração modificadas em massa.
            if (!empty($entitiesToSave)) {
                if ($this->Settings->saveMany($entitiesToSave)) {
                    $this->Flash->success(__('Configurações salvas com sucesso.'));
                    // Redireciona para a própria página de edição para recarregar os dados e exibir as novas imagens.
                    return $this->redirect(['action' => 'edit']);
                } else {
                    // Se saveMany falhar, exibe um erro genérico.
                    $this->Flash->error(__('Não foi possível salvar algumas configurações. Por favor, tente novamente.'));
                }
            } else {
                // Se nenhuma alteração foi detectada ou nenhum arquivo foi enviado.
                $this->Flash->info(__('Nenhuma alteração para salvar.'));
            }
        }

        // Passa as entidades de configuração e as definições das chaves para a view.
        $this->set(compact('settings', 'configKeys'));
    }
}
