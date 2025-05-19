<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Inscricoes Controller
 *
 * @property \App\Model\Table\InscricoesTable $Inscricoes
 */
class InscricoesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Inscricoes->find()
            ->contain(['Alunos', 'Atividades', 'Users', 'Responsavels']);
        $inscricoes = $this->paginate($query);

        $this->set(compact('inscricoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Inscrico id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inscrico = $this->Inscricoes->get($id, contain: ['Alunos', 'Atividades', 'Users', 'Responsavels']);
        $this->set(compact('inscrico'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inscrico = $this->Inscricoes->newEmptyEntity();
        if ($this->request->is('post')) {
            $inscrico = $this->Inscricoes->patchEntity($inscrico, $this->request->getData());
            if ($this->Inscricoes->save($inscrico)) {
                $this->Flash->success(__('The inscrico has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inscrico could not be saved. Please, try again.'));
        }
        $alunos = $this->Inscricoes->Alunos->find('list', ['keyField' => 'id', 'valueField' => 'nome_completo'])->toArray();
        $atividades = $this->Inscricoes->Atividades->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $users = $this->Inscricoes->Users->find('list', limit: 200)->all();
        $responsavels = $this->Inscricoes->Responsavels->find('list', limit: 200)->all();
        $this->set(compact('inscrico', 'alunos', 'atividades', 'users', 'responsavels'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inscrico id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inscrico = $this->Inscricoes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inscrico = $this->Inscricoes->patchEntity($inscrico, $this->request->getData());
            if ($this->Inscricoes->save($inscrico)) {
                $this->Flash->success(__('The inscrico has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inscrico could not be saved. Please, try again.'));
        }
        $alunos = $this->Inscricoes->Alunos->find('list', limit: 200)->all();
        $atividades = $this->Inscricoes->Atividades->find('list', limit: 200)->all();
        $users = $this->Inscricoes->Users->find('list', limit: 200)->all();
        $responsavels = $this->Inscricoes->Responsavels->find('list', limit: 200)->all();
        $this->set(compact('inscrico', 'alunos', 'atividades', 'users', 'responsavels'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inscrico id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inscrico = $this->Inscricoes->get($id);
        if ($this->Inscricoes->delete($inscrico)) {
            $this->Flash->success(__('The inscrico has been deleted.'));
        } else {
            $this->Flash->error(__('The inscrico could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
