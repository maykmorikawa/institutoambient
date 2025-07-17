<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\FrozenDate; // Certifique-se de que está importado
use Cake\Http\Exception\NotFoundException; // Importar para exceções de record not found
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Presencas Controller
 *
 * @property \App\Model\Table\PresencasTable $Presencas
 */
class PresencasController extends AppController
{

    /**
     * Inicializa o controller.
     */
    public function initialize(): void
    {
        parent::initialize();
        // Não é necessário carregar explicitamente os modelos aqui com loadModel().
        // Usaremos $this->fetchTable() nos métodos.
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Presencas->find()
            ->contain(['Aulas', 'Alunos']);
        $presencas = $this->paginate($query);

        $this->set(compact('presencas'));
    }

    /**
     * View method
     *
     * @param string|null $id Presenca id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $presenca = $this->Presencas->get($id, contain: ['Aulas', 'Alunos']);
        $this->set(compact('presenca'));
    }

    public function marcar($aulaId = null)
    {
        // Obtém instâncias das tabelas necessárias usando fetchTable().
        $aulasTable = $this->fetchTable('Aulas');
        $inscricoesTable = $this->fetchTable('Inscricoes');
        $presencasTable = $this->fetchTable('Presencas'); // A tabela principal do controller ($this->Presencas) já é carregada automaticamente.

        try {
            // Carrega a entidade da Aula pelo ID, incluindo suas Atividades relacionadas
            // e as Presenças existentes com os Alunos associados.
            // Uso de argumentos nomeados 'contain:' conforme recomendação do CakePHP 5.x.
            $aula = $aulasTable->get($aulaId, contain: [
                'Atividades', // Para acessar o nome da atividade e seu ID.
                'Presencas.Alunos', // Carrega os registros de presença existentes para esta aula, e os dados dos alunos associados a essas presenças.
            ]);
        } catch (RecordNotFoundException $e) {
            // Se a aula não for encontrada, exibe uma mensagem de erro e redireciona.
            $this->Flash->error(__('Aula não encontrada.'));
            // Tenta redirecionar para a página anterior, ou para a lista de atividades como fallback.
            return $this->redirect($this->referer() ?: ['controller' => 'Atividades', 'action' => 'index']);
        }

        // Obtém todos os alunos que estão inscritos e com status 'confirmada' na atividade
        // à qual esta aula pertence. Estes são os alunos que deveriam estar na aula.
        $alunosInscritosConfirmados = $inscricoesTable->find()
            ->contain(['Alunos']) // Carrega a entidade 'Aluno' para cada 'Inscrição'.
            ->where([
                'Inscricoes.atividade_id' => $aula->atividade->id, // Filtra pela atividade da aula atual.
                'Inscricoes.status' => 'confirmada' // Considera apenas inscrições com status 'confirmada'.
            ])
            ->order(['Alunos.nome_completo' => 'ASC']) // Opcional: ordena os alunos por nome completo para melhor visualização.
            ->toArray(); // Executa a consulta e converte o resultado em um array de entidades.

        // Mapeia as presenças existentes para fácil acesso.
        // Isso cria um array onde a chave é o ID do aluno e o valor é a entidade 'Presenca' correspondente.
        // Facilita a verificação se um aluno já tem um registro de presença para esta aula.
        $presencasExistentes = [];
        foreach ($aula->presencas as $presenca) {
            $presencasExistentes[$presenca->aluno_id] = $presenca;
        }

        // Processa o envio do formulário de frequência (requisições POST ou PUT).
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData(); // Obtém todos os dados enviados pelo formulário.
            $presencasParaSalvar = []; // Array para armazenar as entidades de Presença a serem salvas/atualizadas.

            // Itera sobre cada aluno que deveria estar na aula (alunos inscritos confirmados).
            foreach ($alunosInscritosConfirmados as $inscricao) {
                $alunoId = $inscricao->aluno->id;
                // Verifica se o checkbox de presença para este aluno foi marcado no formulário.
                // O valor '1' é o que esperamos de um checkbox marcado no CakePHP FormHelper.
                $isPresent = isset($data['presenca'][$alunoId]) && $data['presenca'][$alunoId] === '1';

                // Verifica se já existe um registro de presença para este aluno e esta aula.
                if (isset($presencasExistentes[$alunoId])) {
                    $presenca = $presencasExistentes[$alunoId];
                    // Se o status de presença mudou (do banco para o formulário), atualiza a entidade.
                    if ($presenca->presente != (int) $isPresent) {
                        $presenca->presente = (int) $isPresent;
                        $presencasParaSalvar[] = $presenca; // Adiciona à lista para salvamento.
                    }
                } else {
                    // Se não existe um registro de presença, cria uma nova entidade.
                    // Um registro é criado mesmo se o aluno estiver ausente (presente = 0)
                    // para manter um histórico completo de quem deveria estar na aula.
                    $presenca = $presencasTable->newEmptyEntity();
                    $presenca->aula_id = $aulaId;
                    $presenca->aluno_id = $alunoId;
                    $presenca->presente = (int) $isPresent; // Define 0 para ausente, 1 para presente.
                    $presencasParaSalvar[] = $presenca; // Adiciona à lista para salvamento.
                }
            }

            $connection = ConnectionManager::get('default'); // Obtém a conexão do banco de dados.
            try {
                // Inicia uma transação para salvar/atualizar todas as presenças.
                $connection->transactional(function () use ($presencasParaSalvar, $presencasTable) {
                    // Tenta salvar todas as entidades de presença em massa.
                    // saveMany é mais eficiente para múltiplos registros.
                    if (!$presencasTable->saveMany($presencasParaSalvar)) {
                        // Se o saveMany falhar (ex: erro de validação, erro no banco),
                        // lança uma exceção para acionar o rollback da transação.
                        throw new \Exception(__('Erro ao salvar algumas presenças.'));
                    }
                });
                // Se a transação for bem-sucedida, exibe mensagem de sucesso.
                $this->Flash->success(__('Frequência marcada com sucesso.'));
                // Redireciona de volta para a view da atividade à qual a aula pertence.
                return $this->redirect(['controller' => 'Atividades', 'action' => 'view', $aula->atividade->id]);
            } catch (\Exception $e) {
                // Se uma exceção for capturada (transação falhou), exibe mensagem de erro.
                $this->Flash->error(__('Não foi possível marcar a frequência: ' . $e->getMessage()));
            }
        }

        // Passa os dados necessários para a view (templates/Admin/Presencas/marcar.php).
        $this->set(compact('aula', 'alunosInscritosConfirmados', 'presencasExistentes'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $presenca = $this->Presencas->newEmptyEntity();
        if ($this->request->is('post')) {
            $presenca = $this->Presencas->patchEntity($presenca, $this->request->getData());
            if ($this->Presencas->save($presenca)) {
                $this->Flash->success(__('The presenca has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The presenca could not be saved. Please, try again.'));
        }
        $aulas = $this->Presencas->Aulas->find('list', limit: 200)->all();
        $alunos = $this->Presencas->Alunos->find('list', limit: 200)->all();
        $this->set(compact('presenca', 'aulas', 'alunos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Presenca id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $presenca = $this->Presencas->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $presenca = $this->Presencas->patchEntity($presenca, $this->request->getData());
            if ($this->Presencas->save($presenca)) {
                $this->Flash->success(__('The presenca has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The presenca could not be saved. Please, try again.'));
        }
        $aulas = $this->Presencas->Aulas->find('list', limit: 200)->all();
        $alunos = $this->Presencas->Alunos->find('list', limit: 200)->all();
        $this->set(compact('presenca', 'aulas', 'alunos'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Presenca id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $presenca = $this->Presencas->get($id);
        if ($this->Presencas->delete($presenca)) {
            $this->Flash->success(__('The presenca has been deleted.'));
        } else {
            $this->Flash->error(__('The presenca could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
