<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\EventInterface;  // 👈 Adicione esta linha
use Cake\I18n\Date;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Exception\RecordNotFoundException; // Adicionar para a exceção do get()
use Cake\ORM\TableRegistry; // You might still use this directly in some cases, but fetchTable is better.

/**
 * Atividades Controller
 *
 *
 * @property \App\Model\Table\AtividadesTable $Atividades
 * @property \App\Controller\Component\FlashComponent $Flash
 * @property \App\Model\Table\ProjetosTable $Projetos // Add property hints for better IDE support
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\InscricoesTable $Inscricoes
 * @property \App\Model\Table\AulasTable $Aulas
 * @property \App\Model\Table\PresencasTable $Presencas
 * @property \App\Model\Table\AlunosTable $Alunos
 *
 * @method \App\Model\Entity\Atividade[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class AtividadesController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        // You don't need to explicitly "load" models for associated tables
        // here if you're accessing them via $this->fetchTable() in your methods.
        // The default controller behavior automatically loads the primary table ($this->Atividades).
        // If you need access to other tables frequently throughout the controller,
        // you would typically fetch them *once* per request or when needed.
        // For the purpose of the `gerarAulasEMatricularAlunos` method,
        // fetching them inside that method is perfectly fine.
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
    public function view1($id = null)
    {
        $atividade = $this->Atividades->get($id, contain: [
            'Projetos',
            'Users',
            'Aulas',
            'Inscricoes' => ['Alunos', 'Users', 'Responsavels', 'Atividades'] // <- aqui está o segredo
        ]);
        $this->set(compact('atividade'));
    }

    public function view($id = null)
    {
        try {
            $atividade = $this->Atividades->get($id, contain: [ // << AQUI ESTÁ A MUDANÇA: use 'contain:'
                'Projetos',
                'Users',
                'Inscricoes.Alunos',
                'Aulas' => [
                    'sort' => ['Aulas.data' => 'ASC'],
                    'Presencas.Alunos'
                ],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Atividade não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('atividade'));
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

    public function add()
    {
        $atividade = $this->Atividades->newEmptyEntity();
        if ($this->request->is('post')) {
            $atividade = $this->Atividades->patchEntity($atividade, $this->request->getData());

            $connection = ConnectionManager::get('default');
            $success = false;

            try {
                $connection->transactional(function () use ($atividade, &$success) {
                    if ($this->Atividades->save($atividade)) {
                        // A lógica de gerarAulasEMatricularAlunos não é chamada aqui no ADD,
                        // pois os alunos só se inscreverão depois.
                        // Essa lógica será chamada no EDIT (se as datas mudarem) ou em um método manual.
                        $success = true;
                    } else {
                        $errors = $atividade->getErrors();
                        $errorMessage = __('Erro ao salvar a atividade: ');
                        foreach ($errors as $field => $messages) {
                            $errorMessage .= $field . ': ' . implode(', ', $messages) . ' ';
                        }
                        if (empty($errors)) {
                            $errorMessage = __('Erro desconhecido ao salvar a atividade principal. Verifique os logs.');
                        }
                        throw new \Exception($errorMessage);
                    }
                });
            } catch (\Exception $e) {
                $this->Flash->error(__('Não foi possível salvar a atividade: ' . $e->getMessage()));
                $success = false;
            }

            if ($success) {
                $this->Flash->success(__('Atividade salva com sucesso!'));
                if (!empty($atividade->link_inscricao)) {
                    $this->Flash->success(
                        'Link de inscrição: ' . $atividade->link_inscricao,
                        ['escape' => false]
                    );
                }
                return $this->redirect(['action' => 'index']);
            }
        }

        $projetos = $this->fetchTable('Projetos')->find('list', keyField: 'id', valueField: 'name')->toArray();
        $users = $this->fetchTable('Users')->find('list', keyField: 'id', valueField: 'name')->toArray();
        $this->set(compact('atividade', 'projetos', 'users'));
    }

    /**
     * Método Editar
     * Edita uma atividade existente.
     *
     * @param string|null $id ID da Atividade.
     * @return \Cake\Http\Response|null|void Redireciona em caso de sucesso, renderiza a view caso contrário.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não for encontrado.
     */
    public function edit($id = null)
    {
        try {
            $atividade = $this->Atividades->get($id, contain: []);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Atividade não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        $originalStartDate = $atividade->data_inicio;
        $originalEndDate = $atividade->data_fim;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $atividade = $this->Atividades->patchEntity($atividade, $this->request->getData());

            $connection = ConnectionManager::get('default');
            $success = false;

            try {
                $connection->transactional(function () use ($atividade, $originalStartDate, $originalEndDate, &$success) {
                    if ($this->Atividades->save($atividade)) {
                        // Verifica se as datas foram alteradas para regenerar aulas e matrículas
                        if ($atividade->data_inicio != $originalStartDate || $atividade->data_fim != $originalEndDate) {
                            $this->gerarAulasEMatricularAlunos(
                                $atividade->id,
                                $atividade->data_inicio,
                                $atividade->data_fim,
                                false // Indica que NÃO é uma nova atividade (para limpar aulas antigas)
                            );
                        }
                        $success = true;
                    } else {
                        $errors = $atividade->getErrors();
                        $errorMessage = __('Erro ao atualizar a atividade: ');
                        foreach ($errors as $field => $messages) {
                            $errorMessage .= $field . ': ' . implode(', ', $messages) . ' ';
                        }
                        throw new \Exception($errorMessage);
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
        }

        $projetos = $this->fetchTable('Projetos')->find('list', keyField: 'id', valueField: 'name')->toArray();
        $users = $this->fetchTable('Users')->find('list', keyField: 'id', valueField: 'name')->toArray();
        $this->set(compact('atividade', 'projetos', 'users'));
    }

    /**
     * Método auxiliar para gerar aulas e matricular alunos.
     * Este método é chamado internamente pelos métodos add() e edit().
     *
     * @param int $idAtividade ID da atividade.
     * @param \Cake\I18n\Date $dataInicio Objeto Date com a data de início da atividade.
     * @param \Cake\I18n\Date $dataFim Objeto Date com a data de fim da atividade.
     * @param bool $isNewActivity Indica se a atividade é nova (true) ou está sendo editada (false).
     * @return void
     */
    protected function gerarAulasEMatricularAlunos(int $idAtividade, Date $dataInicio, Date $dataFim, bool $isNewActivity): void
    {
        $aulasTable = $this->fetchTable('Aulas');
        $inscricoesTable = $this->fetchTable('Inscricoes');
        $presencasTable = $this->fetchTable('Presencas');
        // $alunosTable = $this->fetchTable('Alunos'); // Não diretamente usado aqui, mas pode ser útil em outras lógicas.

        // 1. Remover aulas e associações de alunos existentes, SE NÃO for uma nova atividade.
        if (!$isNewActivity) {
            $aulasAntigasIds = $aulasTable->find()
                ->select(['id'])
                ->where(['atividade_id' => $idAtividade])
                ->extract('id')
                ->toArray();

            if (!empty($aulasAntigasIds)) {
                $presencasTable->deleteAll(['aula_id IN' => $aulasAntigasIds]);
                $aulasTable->deleteAll(['id IN' => $aulasAntigasIds]);
            }
        }

        $aulasParaSalvar = [];
        $currentDate = new Date($dataInicio);
        $endDate = new Date($dataFim);

        // 2. Gerar as novas aulas para cada dia válido no período
        // CORREÇÃO APLICADA: Usando o operador de comparação '<=' para objetos Date.
        while ($currentDate <= $endDate) {
            if ($currentDate->isWeekday()) {
                $aula = $aulasTable->newEmptyEntity();
                $aula->atividade_id = $idAtividade;
                $aula->data = $currentDate->format('Y-m-d');
                $aulasParaSalvar[] = $aula;
            }
            $currentDate = $currentDate->addDays(1);
        }

        if (!empty($aulasParaSalvar)) {
            $savedAulas = $aulasTable->saveMany($aulasParaSalvar);

            // 3. Obter os IDs dos alunos ATIVAMENTE inscritos (confirmados) nesta atividade
            // CORREÇÃO APLICADA: Adicionado ->all() antes de ->extract() para executar a query.
            $alunosInscritosIds = $inscricoesTable->find()
                ->select(['Inscricoes.aluno_id'])
                ->where([
                    'Inscricoes.atividade_id' => $idAtividade,
                    'Inscricoes.status' => 'confirmada'
                ])
                ->all() // <-- ESTA LINHA FOI ADICIONADA/RESTAURADA
                ->extract('aluno_id')
                ->toArray();

            if (!empty($alunosInscritosIds) && !empty($savedAulas)) {
                $presencasParaSalvar = [];
                foreach ($savedAulas as $aula) {
                    foreach ($alunosInscritosIds as $alunoId) {
                        $presenca = $presencasTable->newEmptyEntity();
                        $presenca->aula_id = $aula->id;
                        $presenca->aluno_id = $alunoId;
                        $presenca->presente = 0;
                        $presencasParaSalvar[] = $presenca;
                    }
                }
                if (!$presencasTable->saveMany($presencasParaSalvar)) {
                    throw new \Exception(__('Falha ao matricular alunos nas aulas.'));
                }
            }
        }
    }
}
