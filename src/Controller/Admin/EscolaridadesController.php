<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Escolaridades Controller
 *
 * @property \App\Model\Table\EscolaridadesTable $Escolaridades
 */
class EscolaridadesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Escolaridades->find()
            ->contain(['Alunos']);
        $escolaridades = $this->paginate($query);

        $this->set(compact('escolaridades'));
    }

    /**
     * View method
     *
     * @param string|null $id Escolaridade id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $escolaridade = $this->Escolaridades->get($id, contain: ['Alunos']);
        $this->set(compact('escolaridade'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $escolaridade = $this->Escolaridades->newEmptyEntity();
        if ($this->request->is('post')) {
            $escolaridade = $this->Escolaridades->patchEntity($escolaridade, $this->request->getData());
            if ($this->Escolaridades->save($escolaridade)) {
                $this->Flash->success(__('The escolaridade has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The escolaridade could not be saved. Please, try again.'));
        }
        $alunos = $this->Escolaridades->Alunos->find('list', limit: 200)->all();
        $this->set(compact('escolaridade', 'alunos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Escolaridade id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $escolaridade = $this->Escolaridades->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $escolaridade = $this->Escolaridades->patchEntity($escolaridade, $this->request->getData());
            if ($this->Escolaridades->save($escolaridade)) {
                $this->Flash->success(__('The escolaridade has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The escolaridade could not be saved. Please, try again.'));
        }
        $alunos = $this->Escolaridades->Alunos->find('list', limit: 200)->all();
        $this->set(compact('escolaridade', 'alunos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Escolaridade id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $escolaridade = $this->Escolaridades->get($id);
        if ($this->Escolaridades->delete($escolaridade)) {
            $this->Flash->success(__('The escolaridade has been deleted.'));
        } else {
            $this->Flash->error(__('The escolaridade could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
