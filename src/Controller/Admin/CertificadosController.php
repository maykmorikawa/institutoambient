<?php
// src/Controller/Admin/CertificadosController.php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;
use Cake\I18n\Date;
use Cake\I18n\I18n; // ✅ CORREÇÃO: Esta linha é essencial para a formatação de datas.
use Cake\Routing\Router;
use Cake\View\View;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Dompdf\Dompdf;
use Dompdf\Options;

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
 * @property \App\Model\Table\SettingsTable $Settings
 * @property \App\Controller\Component\FlashComponent $Flash
 * @property \Cake\View\Helper\UrlHelper $Url
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
        // Os models são carregados via fetchTable() diretamente na action, o que é uma boa prática.
    }

    /**
     * Action para gerar um certificado em PDF.
     *
     * @param string|null $alunoId ID do Aluno.
     * @param string|null $atividadeId ID da Atividade.
     * @return \Cake\Http\Response|null|void
     */
    public function gerar(string $alunoId = null, string $atividadeId = null): ?Response
    {
        set_time_limit(300);

        // 1. Busca dos dados principais
        $alunosTable = $this->fetchTable('Alunos');
        $atividadesTable = $this->fetchTable('Atividades');
        $aulasTable = $this->fetchTable('Aulas');
        $presencasTable = $this->fetchTable('Presencas');
        $certificadosTable = $this->fetchTable('Certificados');

        try {
            $aluno = $alunosTable->get($alunoId);
            $atividade = $atividadesTable->get($atividadeId);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Aluno ou Atividade não encontrados.'));
            return $this->redirect($this->referer());
        }

        // 2. Lógica de cálculo da carga horária (2 horas por presença)
        $aulasPresentesCount = $presencasTable->find()
            ->innerJoinWith('Aulas', fn($q) => $q->where(['Aulas.atividade_id' => $atividadeId]))
            ->where(['Presencas.aluno_id' => $aluno->id, 'Presencas.presente' => true])
            ->count();

        if ($aulasPresentesCount === 0) {
            $this->Flash->error(__('Não foi encontrada nenhuma presença para este aluno na atividade.'));

            $msg = sprintf(
                'DIAGNÓSTICO: Inconsistência de dados. O aluno "%s" tem %d presença(s)...',
                // ... (resto da mensagem) ...
            );
            $this->Flash->error($msg);

            // ADICIONE ESTA LINHA TEMPORARIAMENTE
            die($msg);
            return $this->redirect($this->referer());
        }

        $horasPorAula = 2.0;
        $cargaHorariaCalculada = $aulasPresentesCount * $horasPorAula;

        try {
            // 3. Salvar os dados do certificado no banco
            $connection = ConnectionManager::get('default');
            $certificado = null;
            $connection->transactional(function () use ($aluno, $atividade, $certificadosTable, $cargaHorariaCalculada, &$certificado) {
                $certificado = $certificadosTable->find()->where(['aluno_id' => $aluno->id, 'atividade_id' => $atividade->id])->first();
                if (!$certificado) $certificado = $certificadosTable->newEmptyEntity();

                $certificado->aluno_id = $aluno->id;
                $certificado->atividade_id = $atividade->id;
                $certificado->carga_horaria_total = $cargaHorariaCalculada;
                $certificado->data_emissao = new Date();
                if (!$certificadosTable->save($certificado)) throw new \Exception('Erro ao salvar certificado.');
            });

            // 4. Preparar todas as variáveis para o template
            I18n::setLocale('pt-BR');
            $dataEmissaoFormatada = $certificado->data_emissao->i18nFormat("dd 'de' MMMM 'de' yyyy");
            $dataCompleta = 'Belém (PA), ' . $dataEmissaoFormatada;

            $verificationUrl = Router::url(['controller' => 'Certificados', 'action' => 'verificar', $certificado->codigo_autenticacao, 'prefix' => false], true);
            $qrCodeDataUri = (new QRCode(new QROptions(['outputType' => QRCode::OUTPUT_IMAGE_PNG, 'imageBase64' => true, 'scale' => 4])))->render($verificationUrl);

            // Usando o caminho absoluto do disco para a imagem de fundo (método mais confiável)
            $nomeDoArquivoDeFundo = 'fundo_certificado.png';
            $caminhoAbsoluto = WWW_ROOT . 'img' . DS . 'uploads' . DS . $nomeDoArquivoDeFundo;
            $bgCertificadoUrl = file_exists($caminhoAbsoluto) ? $caminhoAbsoluto : '';

            // 5. Renderizar o template HTML para uma variável
            $view = new View($this->getRequest());
            $view->set(compact('aluno', 'atividade', 'certificado', 'dataCompleta', 'qrCodeDataUri', 'bgCertificadoUrl'));
            $html = $view->render('Admin/Certificados/pdf/certificado', 'ajax');

            // 6. Converter o HTML para PDF usando Dompdf
            $dompdf = new Dompdf(new Options(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]));
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('certificado.pdf', ["Attachment" => false]);

            return $this->response;
        } catch (\Exception $e) {
            $this->Flash->error(__('Não foi possível gerar o certificado: ' . $e->getMessage()));
            $this->log('Erro ao gerar certificado: ' . $e->getMessage(), 'error');
            return $this->redirect($this->referer());
        }
    }


    // A action 'verificar' parece correta e não foi alterada.
    public function verificar($codigo_autenticacao = null)
    {
        $this->Authorization->skipAuthorization(); // Se você usa o plugin de autorização, é bom garantir que esta action seja pública.

        $certificadosTable = $this->fetchTable('Certificados');

        if (!$codigo_autenticacao) {
            $this->Flash->error(__('Código de autenticação não fornecido.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home', 'prefix' => false]);
        }

        try {
            $certificado = $certificadosTable->find()
                ->where(['codigo_autenticacao' => $codigo_autenticacao])
                ->contain(['Alunos', 'Atividades'])
                ->firstOrFail();

            $this->set(compact('certificado'));
            // Você pode querer um layout diferente para a página de verificação pública.
            // $this->viewBuilder()->setLayout('public'); 

        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Certificado não encontrado ou código inválido.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home', 'prefix' => false]);
        }
    }
}
