<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Alunos Controller
 *
 * @property \App\Model\Table\AlunosTable $Alunos
 */
class AlunosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Alunos->find()
            ->contain(['Users']);
        $alunos = $this->paginate($query);

        $this->set(compact('alunos'));
    }

    /**
     * View method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $aluno = $this->Alunos->get($id, contain: ['Users', 'Inscricoes', 'Presencas', 'Enderecos', 'Escolaridades']);
        $this->set(compact('aluno'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $aluno = $this->Alunos->newEmptyEntity();

        // Recupera atividade_id da URL ou sessão
        $atividade_id = $this->request->getQuery('atividade_id')
            ?? $this->request->getSession()->read('Inscricao.atividade_id');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['atividade_id'] = $atividade_id; // Garante o vínculo

            $aluno = $this->Alunos->patchEntity($aluno, $data);

            if ($this->Alunos->save($aluno)) {
                debug([
                    'expected_redirect' => [
                        'controller' => 'Inscricoes',
                        'action' => 'processarInscricao',
                        '?' => [
                            'atividade_id' => $atividade_id,
                            'aluno_id' => $aluno->id
                        ]
                    ],
                    'actual_data' => $aluno->toArray()
                ]);
                exit;

                // return $this->redirect(...); // Comente temporariamente
            }
        }

        // Passa atividade_id para o template
        $users = $this->Alunos->Users->find('list', limit: 200)->all();
        $this->set(compact('aluno', 'users', 'atividade_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $aluno = $this->Alunos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $aluno = $this->Alunos->patchEntity($aluno, $this->request->getData());
            if ($this->Alunos->save($aluno)) {
                $this->Flash->success(__('The aluno has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The aluno could not be saved. Please, try again.'));
        }
        $users = $this->Alunos->Users->find('list', limit: 200)->all();
        $this->set(compact('aluno', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $aluno = $this->Alunos->get($id);
        if ($this->Alunos->delete($aluno)) {
            $this->Flash->success(__('The aluno has been deleted.'));
        } else {
            $this->Flash->error(__('The aluno could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
