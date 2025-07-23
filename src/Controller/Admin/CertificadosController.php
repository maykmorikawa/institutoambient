<?php
// src/Controller/Admin/CertificadosController.php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\Date;
use Dompdf\Dompdf; // Importa a classe Dompdf para geração de PDF
use Dompdf\Options; // Importa a classe Options do Dompdf
use chillerlan\QRCode\{QRCode, QROptions}; // Para gerar QR Code
use Cake\View\View; // Importa a classe View para renderizar templates

/**
 * Certificados Controller
 *
 * Este controller é responsável por gerenciar a geração e verificação de certificados.
 *
 * @property \App\Model\Table\CertificadosTable $Certificados
 * @property \App\Model\Table\AlunosTable $Alunos
 * @property \App\Model\Table\AtividadesTable $Atividades
 * @property \App\Model\Table\AulasTable $Aulas
 * @property \App\Model\Table\PresencasTable $Presencas
 * @property \App\Model\Table\SettingsTable $Settings // Adicionado para acesso à tabela de configurações
 * @property \App\Controller\Component\FlashComponent $Flash
 *
 * @method \App\Model\Entity\Certificado[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CertificadosController extends AppController
{
    /**
     * Inicializa o controller.
     * Este método é chamado antes de qualquer action do controller.
     */
    public function initialize(): void
    {
        parent::initialize();
        
    }

    /**
     * Action para gerar um certificado em PDF.
     *
     * Esta action busca os dados do aluno e da atividade, calcula a carga horária,
     * verifica/cria um registro de certificado no banco de dados e, em seguida,
     * gera o certificado em formato PDF.
     *
     * @param string|null $alunoId ID do Aluno para o certificado.
     * @param string|null $atividadeId ID da Atividade para o certificado.
     * @return \Cake\Http\Response|null|void Retorna uma resposta HTTP com o PDF,
     * ou redireciona em caso de erro.
     */
    public function gerar($alunoId = null, $atividadeId = null)
    {
        // Obtém as instâncias das tabelas necessárias usando $this->fetchTable().
        $alunosTable = $this->fetchTable('Alunos');
        $atividadesTable = $this->fetchTable('Atividades');
        $aulasTable = $this->fetchTable('Aulas');
        $presencasTable = $this->fetchTable('Presencas');
        $certificadosTable = $this->Certificados; // A tabela principal do controller ($this->Certificados) já é carregada automaticamente.

        // Verifica se os IDs do aluno e da atividade foram fornecidos.
        if (!$alunoId || !$atividadeId) {
            $this->Flash->error(__('Aluno ou Atividade não especificados para gerar o certificado.'));
            return $this->redirect($this->referer() ?: ['controller' => 'Atividades', 'action' => 'index']);
        }

        try {
            // Carrega as entidades do Aluno e da Atividade.
            $aluno = $alunosTable->get($alunoId);
            // Carrega a atividade, incluindo o conteúdo programático (se o campo 'conteudo_programatico' existir na tabela 'atividades').
            $atividade = $atividadesTable->get($atividadeId);
        } catch (RecordNotFoundException $e) {
            // Se o aluno ou a atividade não forem encontrados, exibe um erro.
            $this->Flash->error(__('Aluno ou Atividade não encontrados.'));
            return $this->redirect($this->referer() ?: ['controller' => 'Atividades', 'action' => 'index']);
        }

        $connection = ConnectionManager::get('default'); // Obtém a conexão padrão do banco de dados.
        $certificado = null; // Variável para armazenar a entidade do certificado.

        // 1. Carregar as configurações de imagem do banco de dados
        // Busca todas as configurações de imagem e carga horária padrão da tabela 'settings'.
        $settingsData = $this->Settings->find()
            ->select(['key_name', 'value'])
            ->whereIn('key_name', [
                'certificate_bg_page1',
                'certificate_bg_page2',
                'logo_instituto_ambient_ia',
                'logo_equatorial_energia',
                'logo_comdac',
                'logo_instituto_ambient_texto',
                'logo_trabalho_lado_lado',
                'carga_horaria_padrao_aula', // Se você usar essa configuração
            ])
            ->toArray();

        // Mapeia as configurações para um array associativo para fácil acesso.
        $appSettings = [];
        foreach ($settingsData as $setting) {
            $appSettings[$setting->key_name] = $setting->value;
        }

        // Definir o caminho base para as imagens carregadas via upload (relativo a webroot/).
        $imageUploadPath = 'img/';

        // Definir as URLs completas das logos e imagens de fundo dinamicamente.
        // Usa um placeholder se a configuração não estiver definida no banco de dados.
        $bgCertificadoPage1 = $this->Url->image($imageUploadPath . 'backgrounds/' . ($appSettings['certificate_bg_page1'] ?? 'placeholder_bg1.png'), ['fullBase' => true]);
        $bgCertificadoPage2 = $this->Url->image($imageUploadPath . 'backgrounds/' . ($appSettings['certificate_bg_page2'] ?? 'placeholder_bg2.png'), ['fullBase' => true]);
        $logoInstitutoAmbientIA = $this->Url->image($imageUploadPath . 'logos/' . ($appSettings['logo_instituto_ambient_ia'] ?? 'placeholder_ia.png'), ['fullBase' => true]);
        $logoEquatorial = $this->Url->image($imageUploadPath . 'logos/' . ($appSettings['logo_equatorial_energia'] ?? 'placeholder_equatorial.png'), ['fullBase' => true]);
        $logoComdac = $this->Url->image($imageUploadPath . 'logos/' . ($appSettings['logo_comdac'] ?? 'placeholder_comdac.png'), ['fullBase' => true]);
        $logoInstitutoAmbientTexto = $this->Url->image($imageUploadPath . 'logos/' . ($appSettings['logo_instituto_ambient_texto'] ?? 'placeholder_instituto.png'), ['fullBase' => true]);
        $logoTrabalhoLadoLado = $this->Url->image($imageUploadPath . 'logos/' . ($appSettings['logo_trabalho_lado_lado'] ?? 'placeholder_trabalho.png'), ['fullBase' => true]);


        try {
            // Inicia uma transação no banco de dados para garantir a atomicidade das operações.
            $connection->transactional(function () use ($aluno, $atividade, $aulasTable, $presencasTable, $certificadosTable, $appSettings, &$certificado) {
                // 2. Calcular Carga Horária
                // Conta o número de aulas para esta atividade onde o aluno esteve presente.
                $aulasPresentesCount = $presencasTable->find()
                    ->where([
                        'Presencas.aluno_id' => $aluno->id,
                        'Presencas.presente' => true, // Apenas aulas onde o aluno foi marcado como presente.
                        // Garante que as presenças são apenas para as aulas pertencentes a esta atividade.
                        'Presencas.aula_id IN' => $aulasTable->find()->select(['id'])->where(['atividade_id' => $atividade->id])->all()->extract('id')->toArray()
                    ])
                    ->count();

                // Define a carga horária total.
                // Opção 1: Se a atividade tiver um campo 'carga_horaria' (preferencial se for um valor fixo da atividade).
                // Opção 2: Calcula com base no número de aulas presentes (ex: 1 hora por aula presente),
                //         usando a configuração 'carga_horaria_padrao_aula' se definida.
                $cargaHorariaPorAulaConfig = (float)($appSettings['carga_horaria_padrao_aula'] ?? 1); // Padrão 1 hora
                $cargaHorariaTotal = $atividade->carga_horaria ?? ($aulasPresentesCount * $cargaHorariaPorAulaConfig);

                // 3. Verificar se um certificado já existe para este aluno e atividade.
                $certificado = $certificadosTable->find()
                    ->where(['aluno_id' => $aluno->id, 'atividade_id' => $atividade->id])
                    ->first();

                if ($certificado) {
                    // Se o certificado já existe, apenas atualiza a carga horária e a data de emissão.
                    $certificado->carga_horaria_total = $cargaHorariaTotal;
                    $certificado->data_emissao = new Date();
                } else {
                    // Se o certificado não existe, cria uma nova entidade de certificado.
                    $certificado = $certificadosTable->newEmptyEntity();
                    $certificado->aluno_id = $aluno->id;
                    $certificado->atividade_id = $atividade->id;
                    $certificado->carga_horaria_total = $cargaHorariaTotal;
                    $certificado->data_emissao = new Date();
                    // O campo 'codigo_autenticacao' é gerado automaticamente no callback beforeSave do modelo CertificadosTable.
                }

                // Tenta salvar a entidade do certificado (nova ou atualizada).
                if (!$certificadosTable->save($certificado)) {
                    // Se o salvamento falhar, obtém os erros de validação e lança uma exceção para reverter a transação.
                    $errors = $certificado->getErrors();
                    $errorMessage = __('Erro ao salvar o certificado: ');
                    foreach ($errors as $field => $messages) {
                        $errorMessage .= $field . ': ' . implode(', ', $messages) . ' ';
                    }
                    throw new \Exception($errorMessage);
                }
            });

            // 4. Gerar o PDF do Certificado após o sucesso da transação.
            $options = new Options();
            $options->set('defaultFont', 'sans-serif'); // Define a fonte padrão.
            $options->set('isHtml5ParserEnabled', true); // Habilita o parser HTML5.
            $options->set('isRemoteEnabled', true); // Permite ao Dompdf carregar recursos remotos (como imagens de URLs).

            $dompdf = new Dompdf($options);

            // Constrói a URL de verificação para o QR Code.
            // 'prefix' => false é importante se a action 'verificar' for pública e não estiver sob o prefixo 'Admin'.
            $verificationUrl = \Cake\Routing\Router::url([
                'controller' => 'Certificados',
                'action' => 'verificar',
                $certificado->codigo_autenticacao,
                'prefix' => false
            ], true); // 'true' para gerar uma URL absoluta (ex: http://seusite.com/certificados/verificar/CODIGO).

            // Gerar QR Code usando a biblioteca chillerlan/php-qrcode.
            $qrCodeDataUri = '';
            // A biblioteca chillerlan/php-qrcode precisa ser instalada via composer
            // composer require chillerlan/php-qrcode
            if (class_exists(QRCode::class)) {
                $qrOptions = new QROptions([
                    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                    'eccLevel' => QRCode::ECC_L, // Nível de correção de erro (L, M, Q, H).
                    'scale' => 4, // Escala do QR Code (tamanho).
                    'imageBase64' => true, // Retorna o QR Code como Data URI (incorporado no HTML).
                ]);
                $qrcode = new QRCode($qrOptions);
                $qrCodeDataUri = $qrcode->render($verificationUrl);
            } else {
                // Fallback se a biblioteca QR Code não estiver instalada.
                $qrCodeDataUri = 'data:image/png;base64,' . base64_encode(file_get_contents('https://placehold.co/150x150/cccccc/000000?text=QR+Code'));
            }

            // Renderiza a view do certificado (templates/Admin/Certificados/pdf/certificado.php) como HTML.
            // 'ajax' é usado para não incluir o layout padrão do CakePHP na renderização do PDF.
            $view = new View($this->getRequest());
            // Passa todas as variáveis necessárias para a view do PDF, incluindo as URLs das imagens.
            $view->set(compact('aluno', 'atividade', 'certificado', 'verificationUrl', 'qrCodeDataUri',
                               'bgCertificadoPage1', 'bgCertificadoPage2',
                               'logoInstitutoAmbientIA', 'logoEquatorial', 'logoComdac',
                               'logoInstitutoAmbientTexto', 'logoTrabalhoLadoLado'));
            $html = $view->render('Admin/Certificados/pdf/certificado', 'ajax');

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape'); // Define o tamanho do papel e a orientação (paisagem).
            $dompdf->render(); // Gera o PDF.

            // 5. Enviar o PDF para o navegador.
            $fileName = 'certificado_' . $aluno->id . '_' . $atividade->id . '.pdf';
            // 'Attachment' => false faz com que o PDF seja aberto no navegador em vez de forçar o download.
            $dompdf->stream($fileName, ["Attachment" => false]);

            return $this->response; // Retorna a resposta para o CakePHP.
        } catch (\Exception $e) {
            // Em caso de qualquer erro durante a geração do PDF ou transação, exibe uma mensagem de erro.
            $this->Flash->error(__('Não foi possível gerar o certificado: ' . $e->getMessage()));
            return $this->redirect($this->referer() ?: ['controller' => 'Atividades', 'action' => 'index']);
        }
    }

    /**
     * Action para verificar a autenticidade de um certificado.
     * Esta action é projetada para ser acessível publicamente (sem autenticação)
     * para que qualquer pessoa possa verificar a validade de um certificado.
     *
     * @param string|null $codigo_autenticacao O código único de autenticação do certificado.
     * @return \Cake\Http\Response|null|void Renderiza a view de verificação.
     */
    public function verificar($codigo_autenticacao = null)
    {
        // Obtém a instância da tabela Certificados.
        $certificadosTable = $this->fetchTable('Certificados');

        // Verifica se o código de autenticação foi fornecido na URL.
        if (!$codigo_autenticacao) {
            $this->Flash->error(__('Código de autenticação não fornecido.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']); // Redireciona para a página inicial.
        }

        try {
            // Busca o certificado pelo código de autenticação, incluindo os dados do Aluno e da Atividade.
            // firstOrFail() lança uma RecordNotFoundException se o registro não for encontrado.
            $certificado = $certificadosTable->find()
                ->where(['codigo_autenticacao' => $codigo_autenticacao])
                ->contain(['Alunos', 'Atividades'])
                ->firstOrFail();
        } catch (RecordNotFoundException $e) {
            // Se o certificado não for encontrado, exibe uma mensagem de erro.
            $this->Flash->error(__('Certificado não encontrado ou código inválido.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        // Passa a entidade do certificado para a view.
        $this->set(compact('certificado'));
        // Renderiza a view para a verificação do certificado.
        // Certifique-se de que esta view existe em templates/Admin/Certificados/verificar.php
        // Ou em templates/Certificados/verificar.php se a rota for pública e sem prefixo.
    }
}
