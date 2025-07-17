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
                        // Chamar a função de geração de aulas e matrícula
                        $this->gerarAulasEMatricularAlunos(
                            $atividade->id,
                            $atividade->data_inicio,
                            $atividade->data_fim,
                            true // Indica que é uma nova atividade
                        );
                        $success = true;
                    } else {
                        // Se o save da atividade falhar, uma exceção não é lançada por padrão,
                        // então precisamos forçar um erro para a transação reverter.
                        // Usar validationErrors para uma mensagem mais específica.
                        $errors = $atividade->getErrors();
                        $errorMessage = __('Erro ao salvar a atividade: ');
                        foreach ($errors as $field => $messages) {
                            $errorMessage .= implode(', ', $messages) . ' ';
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
                $this->Flash->success(
                    'Link de inscrição: ' . $atividade->link_inscricao,
                    ['escape' => false]
                );
                return $this->redirect(['action' => 'index']);
            }
        }

        // Carrega dados para os selects do formulário
        // Usar $this->fetchTable() para acessar outras tabelas.
        $projetos = $this->fetchTable('Projetos')->find('list', keyField: 'id', valueField: 'name')->toArray();
        $users = $this->fetchTable('Users')->find('list', keyField: 'id', valueField: 'name')->toArray();
        $this->set(compact('atividade', 'projetos', 'users'));
    }

    /**
     * Método Edit
     * Edita uma atividade existente e regera suas aulas se as datas mudarem.
     *
     * @param string|null $id Atividade id.
     * @return \Cake\Http\Response|null|void Redireciona em caso de sucesso, renderiza a view caso contrário.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não for encontrado.
     */
    public function edit($id = null)
    {
        try {
            $atividade = $this->Atividades->get($id, [
                'contain' => [],
            ]);
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
                        if ($atividade->data_inicio != $originalStartDate || $atividade->data_fim != $originalEndDate) {
                            $this->gerarAulasEMatricularAlunos(
                                $atividade->id,
                                $atividade->data_inicio,
                                $atividade->data_fim,
                                false
                            );
                        }
                        $success = true;
                    } else {
                        $errors = $atividade->getErrors();
                        $errorMessage = __('Erro ao atualizar a atividade: ');
                        foreach ($errors as $field => $messages) {
                            $errorMessage .= implode(', ', $messages) . ' ';
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
     * Este método pode ser protected, pois é chamado internamente pelo controller.
     *
     * @param int $idAtividade ID da atividade.
     * @param \Cake\I18n\Date $dataInicio Data de início da atividade.
     * @param \Cake\I18n\Date $dataFim Data de fim da atividade.
     * @param bool $isNewActivity Indica se a atividade é nova (true) ou está sendo editada (false).
     * @return void
     */
    protected function gerarAulasEMatricularAlunos($idAtividade, $dataInicio, $dataFim, $isNewActivity)
    {
        // Use $this->fetchTable() para obter instâncias das tabelas dentro do método
        $aulasTable = $this->fetchTable('Aulas');
        $inscricoesTable = $this->fetchTable('Inscricoes');
        $presencasTable = $this->fetchTable('Presencas');
        $alunosTable = $this->fetchTable('Alunos');

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
        $dataAtual = new Date($dataInicio);
        $dataFinal = new Date($dataFim);

        while ($dataAtual->lte($dataFinal)) {
            if ($dataAtual->isWeekday()) {
                $aula = $aulasTable->newEmptyEntity();
                $aula->atividade_id = $idAtividade;
                $aula->data = $dataAtual->format('Y-m-d');
                $aulasParaSalvar[] = $aula;
            }
            $dataAtual = $dataAtual->addDays(1);
        }

        if (!empty($aulasParaSalvar)) {
            $savedAulas = $aulasTable->saveMany($aulasParaSalvar);

            $alunosInscritosIds = $inscricoesTable->find()
                ->select(['Inscricoes.aluno_id'])
                ->where([
                    'Inscricoes.atividade_id' => $idAtividade,
                    'Inscricoes.status' => 'confirmada'
                ])
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
