<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

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
        $aluno = $this->Alunos->get($id, contain: ['Users', 'Enderecos', 'Escolaridades', 'Inscricoes', 'Presencas']);
        $this->set(compact('aluno'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $aluno = $this->Alunos->newEmptyEntity([
            'associated' => ['Enderecos', 'Escolaridades']
        ]);

        if ($this->request->is('post')) {
            $aluno = $this->Alunos->patchEntity($aluno, $this->request->getData(), [
                'associated' => ['Enderecos', 'Escolaridades']
            ]);

            if ($this->Alunos->save($aluno)) {
                $this->Flash->success(__('O aluno foi salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Não foi possível salvar o aluno. Tente novamente.'));
        }

        $users = $this->Alunos->Users->find('list')->limit(200)->all();
        $this->set(compact('aluno', 'users'));
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
        $aluno = $this->Alunos->get($id, [
            'contain' => ['Enderecos', 'Escolaridades'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            // Debug: veja os dados recebidos
            // debug($this->request->getData()); exit;

            $aluno = $this->Alunos->patchEntity($aluno, $this->request->getData(), [
                'associated' => ['Enderecos', 'Escolaridades']
            ]);

            // Debug: veja a entidade após o patch
            // debug($aluno); exit;

            if ($this->Alunos->save($aluno, ['associated' => ['Enderecos', 'Escolaridades']])) {
                $this->Flash->success(__('O aluno foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o aluno. Tente novamente.'));
        }

        $users = $this->Alunos->Users->find('list', ['limit' => 200]);
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
