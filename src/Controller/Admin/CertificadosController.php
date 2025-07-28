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

        // A lógica inicial para buscar dados e calcular a carga horária continua a mesma.
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

        try {
            $connection = ConnectionManager::get('default');
            $certificado = null;
            $connection->transactional(function () use ($aluno, $atividade, $certificadosTable, $cargaHorariaCalculada, &$certificado) {
                $certificado = $certificadosTable->find()->where(['aluno_id' => $aluno->id, 'atividade_id' => $atividade->id])->first();
                if (!$certificado)
                    $certificado = $certificadosTable->newEmptyEntity();
                $certificado->aluno_id = $aluno->id;
                $certificado->atividade_id = $atividade->id;
                $certificado->carga_horaria_total = $cargaHorariaCalculada;
                $certificado->data_emissao = new Date();
                if (!$certificadosTable->save($certificado))
                    throw new \Exception('Erro ao salvar certificado.');
            });

            // --- INÍCIO DA GERAÇÃO DA IMAGEM PNG ---

            // 1. Caminho para a imagem de fundo e para a fonte
            $caminhoImagemFundo = WWW_ROOT . 'img' . DS . 'uploads' . DS . 'fundo_certificado.png';

            // !!! MUITO IMPORTANTE: AJUSTE O CAMINHO PARA SEU ARQUIVO DE FONTE .TTF !!!
            // Você pode copiar o arial.ttf da pasta C:\Windows\Fonts para uma pasta no seu projeto
            // ou usar o caminho completo se o servidor tiver permissão.
            $caminhoDaFonte = 'C:' . DS . 'Windows' . DS . 'Fonts' . DS . 'arial.ttf';
            $caminhoDaFonteBold = 'C:' . DS . 'Windows' . DS . 'Fonts' . DS . 'arialbd.ttf';

            // Verifica se os arquivos necessários existem
            if (!file_exists($caminhoImagemFundo) || !file_exists($caminhoDaFonte)) {
                $this->Flash->error('Não foi possível encontrar a imagem de fundo ou o arquivo de fonte.');
                return $this->redirect($this->referer());
            }

            // 2. Criar a imagem a partir do fundo
            $imagem = imagecreatefrompng($caminhoImagemFundo);
            $corTexto = imagecolorallocate($imagem, 0, 0, 0); // Cor preta

            // Pega as dimensões da imagem para ajudar a centralizar o texto
            $largura = imagesx($imagem);
            $altura = imagesy($imagem);

            // 3. Escrever os textos na imagem (Ajuste as coordenadas X e Y conforme necessário)
            // imagettftext(imagem, tamanho, angulo, pos_X, pos_Y, cor, fonte, texto)

            // Título "CERTIFICADO DE CONCLUSÃO"
            $textoTitulo = 'CERTIFICADO DE CONCLUSÃO';
            $tamanhoTitulo = 40;
            $caixaTextoTitulo = imagettfbbox($tamanhoTitulo, 0, $caminhoDaFonteBold, $textoTitulo);
            $xTitulo = ($largura - $caixaTextoTitulo[2]) / 2; // Centralizado
            imagettftext($imagem, $tamanhoTitulo, 0, (int) $xTitulo, 200, $corTexto, $caminhoDaFonteBold, $textoTitulo);

            // Texto "Certificamos que"
            imagettftext($imagem, 18, 0, 300, 350, $corTexto, $caminhoDaFonte, 'Certificamos que');

            // Nome do Aluno
            $nomeAluno = $aluno->nome;
            $tamanhoNome = 30;
            $caixaTextoNome = imagettfbbox($tamanhoNome, 0, $caminhoDaFonteBold, $nomeAluno);
            $xNome = ($largura - $caixaTextoNome[2]) / 2; // Centralizado
            imagettftext($imagem, $tamanhoNome, 0, (int) $xNome, 450, $corTexto, $caminhoDaFonteBold, $nomeAluno);

            // Texto principal
            $textoPrincipal = sprintf(
                'concluiu com sucesso a atividade %s, com carga horária total de %d horas.',
                $atividade->nome,
                $certificado->carga_horaria_total
            );
            imagettftext($imagem, 18, 0, 300, 550, $corTexto, $caminhoDaFonte, $textoPrincipal);

            // Data
            I18n::setLocale('pt-BR');
            $dataEmissaoFormatada = $certificado->data_emissao->i18nFormat("dd 'de' MMMM 'de' yyyy");
            $dataCompleta = 'Belém (PA), ' . $dataEmissaoFormatada;
            imagettftext($imagem, 16, 0, 300, 650, $corTexto, $caminhoDaFonte, $dataCompleta);

            // 4. Adicionar o QR Code
            $verificationUrl = Router::url(['controller' => 'Certificados', 'action' => 'verificar', $certificado->codigo_autenticacao, 'prefix' => false], true);
            $qrCodeDataUri = (new QRCode(new QROptions(['outputType' => QRCode::OUTPUT_IMAGE_PNG, 'imageBase64' => true])))->render($verificationUrl);
            $qrCodeString = str_replace('data:image/png;base64,', '', $qrCodeDataUri);
            $qrCodeImagem = imagecreatefromstring(base64_decode($qrCodeString));

            // Colando o QR Code no canto inferior esquerdo (ajuste a posição X=100 e Y=850)
            imagecopy(
                $imagem,                          // Imagem de destino (certificado)
                $qrCodeImagem,                    // Imagem fonte (QR Code)
                100,                              // Posição X no destino
                850,                              // Posição Y no destino
                0,                                // Posição X na fonte
                0,                                // Posição Y na fonte
                imagesx($qrCodeImagem),           // Largura da fonte
                imagesy($qrCodeImagem)            // Altura da fonte
            );

            // 5. Enviar a imagem final para o navegador
            $this->response = $this->response->withType('image/png');
            // Limpa o buffer de saída para evitar corromper a imagem
            ob_start();
            imagepng($imagem);
            $imagemData = ob_get_clean();
            $this->response = $this->response->withStringBody($imagemData);

            // Libera a memória
            imagedestroy($imagem);
            imagedestroy($qrCodeImagem);

            return $this->response;

        } catch (\Exception $e) {
            $this->Flash->error(__('Não foi possível gerar o certificado em imagem: ' . $e->getMessage()));
            $this->log('Erro ao gerar imagem de certificado: ' . $e->getMessage(), 'error');
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