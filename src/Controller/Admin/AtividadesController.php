<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\EventInterface;  // 👈 Adicione esta linha
use Cake\I18n\Date;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Exception\RecordNotFoundException; // Adicionar para a exceção do get()


/**
 * Atividades Controller
 *
 * @property \App\Model\Table\AtividadesTable $Atividades
 */
class AtividadesController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        // Carrega os modelos associados que você usará nos find('list') ou em outras operações
        $this->loadModel('Projetos');
        $this->loadModel('Users');
        $this->loadModel('Inscricoes'); // Carregue Inscricoes para usar no gerarAulasEMatricularAlunos
        $this->loadModel('Aulas');     // Carregue Aulas
        $this->loadModel('Presencas'); // Carregue Presencas
        $this->loadModel('Alunos');    // Carregue Alunos
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Atividades->find()
            ->contain(['Projetos', 'Users']);
        $atividades = $this->paginate($query);

        $this->set(compact('atividades'));
    }

    /**
     * View method
     *
     * @param string|null $id Atividade id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $atividade = $this->Atividades->get($id, contain: [
            'Projetos',
            'Users',
            'Aulas',
            'Inscricoes' => ['Alunos', 'Users', 'Responsavels', 'Atividades'] // <- aqui está o segredo
        ]);
        $this->set(compact('atividade'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $atividade = $this->Atividades->newEmptyEntity();
        if ($this->request->is('post')) {
            $atividade = $this->Atividades->patchEntity($atividade, $this->request->getData());

            $connection = ConnectionManager::get('default');
            $success = false; // Flag para controlar o sucesso da transação

            try {
                $connection->transaction(function () use ($atividade, &$success) {
                    if ($this->Atividades->save($atividade)) {
                        // Chamar a função de geração de aulas e matrícula
                        $this->gerarAulasEMatricularAlunos(
                            $atividade->id,
                            $atividade->data_inicio,
                            $atividade->data_fim,
                            true // Indica que é uma nova atividade
                        );
                        $success = true; // Marca como sucesso dentro da transação
                    } else {
                        // Se o save da atividade falhar, uma exceção não é lançada por padrão,
                        // então precisamos forçar um erro para a transação reverter.
                        // Ou simplesmente não definir $success para true.
                        // Para um rollback explícito ou re-lançamento de erro:
                        throw new \Exception(__('Erro ao salvar a atividade antes de gerar aulas.'));
                    }
                });
            } catch (\Exception $e) {
                // Captura qualquer exceção lançada na transação (incluindo a que forçamos)
                $this->Flash->error(__('Não foi possível salvar a atividade: ' . $e->getMessage()));
                $success = false;
            }

            if ($success) {
                $this->Flash->success(__('Atividade salva com sucesso!'));
                // Mostra o link gerado (opcional)
                $this->Flash->success(
                    'Link de inscrição: ' . $atividade->link_inscricao,
                    ['escape' => false]
                );
                return $this->redirect(['action' => 'index']);
            }
            // Se não for sucesso, a mensagem de erro já foi definida no catch
        }

        // Carrega dados para os selects do formulário (Projetos, Users)
        $projetos = $this->Projetos->find('list', keyField: 'id', valueField: 'name')->toArray();
        $users = $this->Users->find('list', keyField: 'id', valueField: 'name')->toArray();
        $this->set(compact('atividade', 'projetos', 'users'));

        // Se você precisa dos alunos para selecionar no formulário de atividade no "add", descomente abaixo:
        // $alunos = $this->Alunos->find('list', keyField: 'id', valueField: 'nome_completo')->toArray();
        // $this->set(compact('atividade', 'projetos', 'users', 'alunos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Atividade id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            // Carrega a atividade para edição. 'contain' é importante se você precisar de dados relacionados no formulário.
            $atividade = $this->Atividades->get($id, [
                'contain' => [], // Adicione aqui se precisar de contain para o formulário
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Atividade não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        // Guarda as datas originais ANTES de aplicar o patch, para comparação futura.
        // Isso é crucial para `isDirty()` funcionar corretamente para campos de data.
        $originalStartDate = $atividade->data_inicio;
        $originalEndDate = $atividade->data_fim;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $atividade = $this->Atividades->patchEntity($atividade, $this->request->getData());

            $connection = ConnectionManager::get('default');
            $success = false;

            try {
                $connection->transactional(function () use ($atividade, $originalStartDate, $originalEndDate, &$success) {
                    if ($this->Atividades->save($atividade)) {
                        // Verifica se as datas foram alteradas para regenerar
                        // Comparar com os valores originais carregados ANTES do patch.
                        if ($atividade->data_inicio != $originalStartDate || $atividade->data_fim != $originalEndDate) {
                            $this->gerarAulasEMatricularAlunos(
                                $atividade->id,
                                $atividade->data_inicio,
                                $atividade->data_fim,
                                false // Indica que NÃO é uma nova atividade
                            );
                        }
                        $success = true;
                    } else {
                        throw new \Exception(__('Erro ao atualizar a atividade antes de regenerar aulas.'));
                    }
                });
            } catch (\Exception $e) {
                $this->Flash->error(__('Não foi possível atualizar a atividade: ' . $e->getMessage()));
                $success = false;
            }

            if ($success) {
                $this->Flash->success(__('A atividade e suas aulas foram atualizadas com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            // A mensagem de erro já foi definida no catch
        }

        // Carrega dados para os selects do formulário
        $projetos = $this->Projetos->find('list', keyField: 'id', valueField: 'name')->toArray();
        $users = $this->Users->find('list', keyField: 'id', valueField: 'name')->toArray();
        $this->set(compact('atividade', 'projetos', 'users'));

        // Se você precisa dos alunos para selecionar no formulário de atividade no "edit", descomente abaixo:
        // $alunos = $this->Alunos->find('list', keyField: 'id', valueField: 'nome_completo')->toArray();
        // $this->set(compact('atividade', 'projetos', 'users', 'alunos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Atividade id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $atividade = $this->Atividades->get($id);
        if ($this->Atividades->delete($atividade)) {
            $this->Flash->success(__('The atividade has been deleted.'));
        } else {
            $this->Flash->error(__('The atividade could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

     protected function gerarAulasEMatricularAlunos($idAtividade, $dataInicio, $dataFifinal, $isNewActivity)
    {
        // As tabelas já foram carregadas no initialize(), então podemos usá-las diretamente.
        $aulasTable = $this->Aulas;
        $inscricoesTable = $this->Inscricoes;
        $presencasTable = $this->Presencas;
        $alunosTable = $this->Alunos; // Você pode precisar dela para o 'contain' se mudar o find de alunos

        // 1. Remover aulas e associações de alunos existentes se não for uma nova atividade
        if (!$isNewActivity) {
            $aulasAntigasIds = $aulasTable->find()
                ->select(['id'])
                ->where(['atividade_id' => $idAtividade])
                ->extract('id')
                ->toArray();

            if (!empty($aulasAntigasIds)) {
                // Primeiro, remove as presenças (associações de alunos) das aulas antigas
                $presencasTable->deleteAll(['aula_id IN' => $aulasAntigasIds]);
                // Depois, remove as aulas em si
                $aulasTable->deleteAll(['id' => $aulasAntigasIds]);
            }
        }

        $aulasParaSalvar = [];
        $dataAtual = new Date($dataInicio);
        $dataFinal = new Date($dataFifinal); // Usar $dataFim ou renomear a variável local

        // 2. Gerar as novas aulas
        while ($dataAtual <= $dataFinal) {
            // Ajuste a lógica aqui para seus "dias_semana" se precisar de algo mais granular
            // Por exemplo, se atividade->dias_semana for "Seg,Qua,Sex":
            // $diasPermitidos = explode(',', $atividade->dias_semana);
            // if (in_array($dataAtual->i18nFormat('EEE'), $diasPermitidos)) { ... }
            if ($dataAtual->isWeekday()) { // isWeekday() é um método do Cake\I18n\Date
                $aula = $aulasTable->newEmptyEntity();
                $aula->atividade_id = $idAtividade;
                $aula->data = $dataAtual->format('Y-m-d'); // Use o nome do campo real
                $aulasParaSalvar[] = $aula;
            }
            $dataAtual = $dataAtual->addDays(1);
        }

        if (!empty($aulasParaSalvar)) {
            // Salvar as aulas. saveMany retornará as entidades com IDs gerados.
            $savedAulas = $aulasTable->saveMany($aulasParaSalvar);

            // 3. Obter os alunos ATIVAMENTE inscritos nesta atividade através da tabela `inscricoes`
            $alunosInscritosIds = $inscricoesTable->find()
                ->select(['Inscricoes.aluno_id']) // Seleciona apenas o ID do aluno da tabela de junção
                // Não precisa de contain Alunos aqui se você só quer os IDs, otimiza a query.
                ->where([
                    'Inscricoes.atividade_id' => $idAtividade,
                    'Inscricoes.status' => 'confirmada' // Filtra por status 'confirmada'
                ])
                ->extract('aluno_id') // Extrai apenas os IDs dos alunos
                ->toArray();

            if (!empty($alunosInscritosIds) && !empty($savedAulas)) {
                $presencasParaSalvar = [];
                foreach ($savedAulas as $aula) {
                    foreach ($alunosInscritosIds as $alunoId) {
                        // Cria uma nova entidade de presença (associação aula-aluno)
                        $presenca = $presencasTable->newEmptyEntity();
                        $presenca->aula_id = $aula->id;
                        $presenca->aluno_id = $alunoId;
                        $presenca->presente = 0; // Define como não presente por padrão
                        // Outros campos como observacoes podem ser nulos ou preenchidos
                        $presencasParaSalvar[] = $presenca;
                    }
                }
                // Salvar todas as associações de alunos com aulas em massa na tabela 'presencas'
                $presencasTable->saveMany($presencasParaSalvar);
            }
        }
    }
}
