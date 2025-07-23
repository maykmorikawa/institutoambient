<?php
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
 * Controller dos Certificados
 *
 * Este controller é responsável por gerenciar a geração e verificação de certificados.
 *
 * @property \App\Model\Table\CertificadosTable $Certificados
 * @property \App\Model\Table\AlunosTable $Alunos
 * @property \App\Model\Table\AtividadesTable $Atividades
 * @property \App\Model\Table\AulasTable $Aulas
 * @property \App\Model\Table\PresencasTable $Presencas
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
        // REMOVIDO: loadModel() não é mais usado aqui no CakePHP 5.x.
        // As tabelas serão acessadas via $this->fetchTable() diretamente nas actions onde são necessárias.

        // Se você tiver um componente de autenticação e quiser permitir acesso público
        // à action 'verificar', você faria isso aqui. No entanto, se este controller
        // está sob o prefixo 'Admin', a rota 'verificar' também precisaria ser definida
        // fora do prefixo 'Admin' em config/routes.php para ser verdadeiramente pública.
        // Exemplo: $this->Authentication->allowUnauthenticated(['verificar']);
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
        // A tabela principal do controller ($this->Certificados) já é carregada automaticamente.
        $certificadosTable = $this->Certificados;

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

        try {
            // Inicia uma transação no banco de dados para garantir a atomicidade das operações.
            $connection->transactional(function () use ($aluno, $atividade, $aulasTable, $presencasTable, $certificadosTable, &$certificado) {
                // 1. Calcular Carga Horária
                // Conta o número de aulas para esta atividade onde o aluno esteve presente.
                $aulasPresentesCount = $presencasTable->find()
                    ->where([
                        'Presencas.aluno_id' => $aluno->id,
                        'Presencas.presente' => true, // Apenas aulas onde o aluno foi marcado como presente.
                        // Garante que as presenças são apenas para as aulas pertencentes a esta atividade.
                        'Presencas.aula_id IN' => $aulasTable->find()->select(['id'])->where(['atividade_id' => $atividade->id])->toArray()
                    ])
                    ->count();

                // Define a carga horária total.
                // Opção 1: Se a atividade tiver um campo 'carga_horaria' (preferencial se for um valor fixo da atividade).
                // Opção 2: Calcula com base no número de aulas presentes (ex: 1 hora por aula presente).
                $cargaHorariaTotal = $atividade->carga_horaria ?? ($aulasPresentesCount * 1); // Exemplo: 1 hora por aula presente.
                // Se sua carga horária for armazenada em minutos e você quer em horas no certificado, divida por 60.
                // Ex: $cargaHorariaTotal = floor($cargaHorariaTotal / 60);

                // 2. Verificar se um certificado já existe para este aluno e atividade.
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

            // 3. Gerar o PDF do Certificado após o sucesso da transação.
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
            $view->set(compact('aluno', 'atividade', 'certificado', 'verificationUrl', 'qrCodeDataUri'));
            $html = $view->render('Certificados/pdf/certificado', 'ajax');

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape'); // Define o tamanho do papel e a orientação (paisagem).
            $dompdf->render(); // Gera o PDF.

            // 4. Enviar o PDF para o navegador.
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
