<?php
// src/Controller/Admin/CertificadosController.php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;
use Cake\I18n\Date;
use Cake\I18n\I18n;
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
    public function previsualizar(string $alunoId = null, string $atividadeId = null)
    {
        // A lógica de busca de dados e cálculo é a mesma de antes
        $alunosTable = $this->fetchTable('Alunos');
        $atividadesTable = $this->fetchTable('Atividades');
        $aulasTable = $this->fetchTable('Aulas');
        $presencasTable = $this->fetchTable('Presencas');
        $certificadosTable = $this->fetchTable('Certificados');
        $settingsTable = $this->fetchTable('Settings');

        try {
            $aluno = $alunosTable->get($alunoId);
            $atividade = $atividadesTable->get($atividadeId);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Aluno ou Atividade não encontrados.'));
            return $this->redirect($this->referer());
        }

        $aulasPresentesCount = $presencasTable->find()
            ->innerJoinWith('Aulas', fn($q) => $q->where(['Aulas.atividade_id' => $atividadeId]))
            ->where(['Presencas.aluno_id' => $aluno->id, 'Presencas.presente' => true])
            ->count();

        if ($aulasPresentesCount === 0) {
            $this->Flash->error(__('Não foi encontrada nenhuma presença para este aluno na atividade.'));
            return $this->redirect($this->referer());
        }

        $horasPorAula = 2.0;
        $cargaHorariaCalculada = $aulasPresentesCount * $horasPorAula;

        // Salva ou atualiza o certificado para garantir que temos um ID e código de autenticação
        $connection = ConnectionManager::get('default');
        $certificado = $connection->transactional(function () use ($aluno, $atividade, $certificadosTable, $cargaHorariaCalculada) {
            $cert = $certificadosTable->find()->where(['aluno_id' => $aluno->id, 'atividade_id' => $atividade->id])->first();
            if (!$cert)
                $cert = $certificadosTable->newEmptyEntity();

            $cert->aluno_id = $aluno->id;
            $cert->atividade_id = $atividade->id;
            $cert->carga_horaria_total = $cargaHorariaCalculada;
            $cert->data_emissao = new Date();

            if (!$certificadosTable->save($cert)) {
                throw new \Exception('Erro ao salvar registro do certificado.');
            }
            return $cert;
        });

        // Anexa manualmente os objetos para a view
        $certificado->aluno = $aluno;
        $certificado->atividade = $atividade;

        // Prepara as variáveis para a view
        I18n::setLocale('pt-BR');
        $dataCompleta = 'Belém (PA), ' . $certificado->data_emissao->i18nFormat("dd 'de' MMMM 'de' yyyy");
        $qrCodeDataUri = (new QRCode(new QROptions(['outputType' => QRCode::OUTPUT_IMAGE_PNG, 'imageBase64' => true])))->render(Router::url(['action' => 'verificar', $certificado->codigo_autenticacao, 'prefix' => false], true));

        $settingBg = $settingsTable->find()->where(['key_name' => 'certificate_background_default'])->first();
        $bgCertificadoUrl = '';
        if ($settingBg && !empty($settingBg->value)) {
            // ✅ --- AQUI ESTÁ A CORREÇÃO --- ✅
            // Para a pré-visualização no navegador, usamos Router::url() para gerar uma URL web.
            $bgCertificadoUrl = Router::url('/img/uploads/' . $settingBg->value, false);
        }

        // Envia todas as variáveis para o template de pré-visualização
        $this->set(compact('certificado', 'dataCompleta', 'qrCodeDataUri', 'bgCertificadoUrl'));
    }

    /**
     * ETAPA 2: Pega um certificado já existente e o converte para PDF.
     */
    public function gerarPdf($certificadoId = null)
    {
        $this->viewBuilder()->setLayout('ajax'); // Usamos layout AJAX para não ter o HTML do site no PDF

        $certificadosTable = $this->fetchTable('Certificados');
        $settingsTable = $this->fetchTable('Settings');
        try {
            // Buscamos o certificado e seus dados associados
            $certificado = $certificadosTable->get($certificadoId, ['contain' => ['Alunos', 'Atividades']]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Certificado não encontrado.'));
            return $this->redirect(['action' => 'index']); // Redireciona para um lugar seguro
        }

        // Recria as variáveis necessárias para o template do certificado
        I18n::setLocale('pt-BR');
        $dataCompleta = 'Belém (PA), ' . $certificado->data_emissao->i18nFormat("dd 'de' MMMM 'de' yyyy");
        $qrCodeDataUri = (new QRCode(new QROptions(['outputType' => QRCode::OUTPUT_IMAGE_PNG, 'imageBase64' => true])))->render(Router::url(['action' => 'verificar', $certificado->codigo_autenticacao, 'prefix' => false], true));

        $settingBg = $settingsTable->find()->where(['key_name' => 'certificate_background_default'])->first();
        $bgCertificadoUrl = '';
        if ($settingBg && !empty($settingBg->value)) {
            $bgCertificadoUrl = WWW_ROOT . 'img' . DS . 'uploads' . DS . $settingBg->value;
        }

        // Passa as variáveis para a view que será renderizada para o PDF
        $this->set(compact('certificado', 'dataCompleta', 'qrCodeDataUri', 'bgCertificadoUrl'));

        // Renderiza o template para uma variável HTML
        $view = new View($this->getRequest());
        $view->set($this->viewBuilder()->getVars());
        $html = $view->render('Admin/Certificados/pdf_template');

        // Gera o PDF
        $dompdf = new Dompdf(new Options(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('certificado.pdf', ["Attachment" => true]); // true para forçar o download

        return $this->response;
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
