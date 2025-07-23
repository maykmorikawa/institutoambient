<?php
// src/Controller/Admin/CertificadosController.php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\Date;
use Dompdf\Dompdf; // Importa a classe Dompdf
use Dompdf\Options; // Importa a classe Options
use chillerlan\QRCode\{QRCode, QROptions}; // Para gerar QR Code

/**
 * Certificados Controller
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
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Alunos');
        $this->loadModel('Atividades');
        $this->loadModel('Aulas');
        $this->loadModel('Presencas');

        // Permite a action 'verificar' para acesso público (sem autenticação)
        // Se o seu prefixo 'Admin' exige autenticação, você precisará de uma rota separada para isso.
        // Ou mover a action 'verificar' para um controller público (ex: App\Controller\CertificadosController).
        // Por enquanto, vou assumir que você ajustará as permissões conforme sua ACL.
        // $this->Authentication->allowUnauthenticated(['verificar']);
    }

    /**
     * Action para gerar um certificado em PDF.
     *
     * @param string|null $alunoId ID do Aluno.
     * @param string|null $atividadeId ID da Atividade.
     * @return \Cake\Http\Response|null|void
     */
    public function gerar($alunoId = null, $atividadeId = null)
    {
        if (!$alunoId || !$atividadeId) {
            $this->Flash->error(__('Aluno ou Atividade não especificados para gerar o certificado.'));
            return $this->redirect($this->referer() ?: ['controller' => 'Atividades', 'action' => 'index']);
        }

        try {
            $aluno = $this->Alunos->get($alunoId);
            $atividade = $this->Atividades->get($atividadeId);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Aluno ou Atividade não encontrados.'));
            return $this->redirect($this->referer() ?: ['controller' => 'Atividades', 'action' => 'index']);
        }

        $connection = ConnectionManager::get('default');
        $certificado = null;

        try {
            $connection->transactional(function () use ($aluno, $atividade, &$certificado) {
                // 1. Calcular Carga Horária (em minutos ou horas, dependendo da sua necessidade)
                // Aqui, vamos somar a duração de todas as aulas da atividade onde o aluno esteve presente.
                // Isso requer que sua tabela 'aulas' tenha um campo 'duracao' (ex: em minutos).
                // Se não tiver, você pode usar uma carga horária fixa por aula ou da atividade.
                // Para este exemplo, vou assumir uma duração fixa por aula ou que você terá um campo.
                // Se 'horario' na sua atividade for um Time object, você pode calcular a duração da aula a partir dele.
                // Exemplo: se cada aula tem 60 minutos e a presença é marcada.

                // Primeiro, obtenha o total de aulas onde o aluno esteve presente
                $aulasPresentesCount = $this->Presencas->find()
                    ->where([
                        'Presencas.aluno_id' => $aluno->id,
                        'Presencas.presente' => true, // Apenas aulas onde o aluno esteve presente
                        'Presencas.aula_id IN' => $this->Aulas->find()->select(['id'])->where(['atividade_id' => $atividade->id])
                    ])
                    ->count();

                // Assumindo uma carga horária por aula (ex: 60 minutos por aula)
                // Você pode ter um campo 'carga_horaria_por_aula' na tabela 'atividades' ou 'aulas'.
                $cargaHorariaPorAula = 60; // Exemplo: 60 minutos por aula
                $cargaHorariaTotal = $aulasPresentesCount * $cargaHorariaPorAula; // Carga horária em minutos

                // Ou, se a carga horária for da atividade e não por aula:
                // $cargaHorariaTotal = $atividade->carga_horaria_total; // Se você tiver este campo na atividade

                // 2. Verificar se um certificado já existe para este aluno e atividade
                $certificado = $this->Certificados->find()
                    ->where(['aluno_id' => $aluno->id, 'atividade_id' => $atividade->id])
                    ->first();

                if ($certificado) {
                    // Se já existe, apenas atualiza a carga horária e data de emissão
                    $certificado->carga_horaria_total = $cargaHorariaTotal;
                    $certificado->data_emissao = new Date();
                } else {
                    // Se não existe, cria um novo certificado
                    $certificado = $this->Certificados->newEmptyEntity();
                    $certificado->aluno_id = $aluno->id;
                    $certificado->atividade_id = $atividade->id;
                    $certificado->carga_horaria_total = $cargaHorariaTotal;
                    $certificado->data_emissao = new Date();
                    // O codigo_autenticacao é gerado no beforeSave do modelo CertificadosTable
                }

                if (!$this->Certificados->save($certificado)) {
                    $errors = $certificado->getErrors();
                    $errorMessage = __('Erro ao salvar o certificado: ');
                    foreach ($errors as $field => $messages) {
                        $errorMessage .= $field . ': ' . implode(', ', $messages) . ' ';
                    }
                    throw new \Exception($errorMessage);
                }
            });

            // 3. Gerar o PDF do Certificado
            $options = new Options();
            $options->set('defaultFont', 'sans-serif');
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true); // Permite carregar imagens remotas (para QR Code, se for um URL)

            $dompdf = new Dompdf($options);

            // URL de verificação para o QR Code
            $verificationUrl = \Cake\Routing\Router::url([
                'controller' => 'Certificados',
                'action' => 'verificar',
                $certificado->codigo_autenticacao,
                'prefix' => false // Assumindo que a rota de verificação é pública e não no prefixo Admin
            ], true); // true para URL absoluta

            // Gerar QR Code
            $qrCodeDataUri = '';
            if (class_exists(QRCode::class)) { // Verifica se a classe existe (se a biblioteca foi instalada)
                $qrOptions = new QROptions([
                    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                    'eccLevel' => QRCode::ECC_L, // Nível de correção de erro (L, M, Q, H)
                    'scale' => 4, // Escala do QR Code
                    'imageBase64' => true, // Retorna como Data URI
                ]);
                $qrcode = new QRCode($qrOptions);
                $qrCodeDataUri = $qrcode->render($verificationUrl);
            } else {
                // Fallback se a biblioteca QR Code não estiver instalada
                $qrCodeDataUri = 'data:image/png;base64,' . base64_encode(file_get_contents('https://placehold.co/150x150/cccccc/000000?text=QR+Code'));
            }


            // Renderizar a view do certificado como HTML
            // Você precisará criar este template: templates/Admin/Certificados/pdf/certificado.php
            $view = new \Cake\View\View($this->getRequest());
            $view->set(compact('aluno', 'atividade', 'certificado', 'verificationUrl', 'qrCodeDataUri'));
            $html = $view->render('Certificados/pdf/certificado', 'ajax'); // 'ajax' para não usar o layout padrão

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape'); // Orientação paisagem para certificado
            $dompdf->render();

            // 4. Enviar o PDF para o navegador
            $fileName = 'certificado_' . $aluno->id . '_' . $atividade->id . '.pdf';
            $dompdf->stream($fileName, ["Attachment" => false]); // false para abrir no navegador, true para download forçado

            return $this->response; // Retorna a resposta para o CakePHP
        } catch (\Exception $e) {
            $this->Flash->error(__('Não foi possível gerar o certificado: ' . $e->getMessage()));
            return $this->redirect($this->referer() ?: ['controller' => 'Atividades', 'action' => 'index']);
        }
    }

    /**
     * Action para verificar a autenticidade de um certificado.
     * Esta action deve ser acessível publicamente (sem autenticação).
     *
     * @param string|null $codigo_autenticacao O código único do certificado.
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function verificar($codigo_autenticacao = null)
    {
        if (!$codigo_autenticacao) {
            $this->Flash->error(__('Código de autenticação não fornecido.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']); // Redireciona para uma página inicial
        }

        try {
            $certificado = $this->Certificados->find()
                ->where(['codigo_autenticacao' => $codigo_autenticacao])
                ->contain(['Alunos', 'Atividades'])
                ->firstOrFail(); // Lança RecordNotFoundException se não encontrar
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Certificado não encontrado ou código inválido.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $this->set(compact('certificado'));
        // Renderiza uma view específica para a verificação do certificado
        // templates/Certificados/verificar.php (se for controller público)
        // ou templates/Admin/Certificados/verificar.php (se for manter no Admin)
    }
}