<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Atividades Controller
 *
 * @property \App\Model\Table\AtividadesTable $Atividades
 */
class AtividadesController extends AppController
{
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
        $atividade = $this->Atividades->get($id, contain: ['Projetos', 'Users', 'Aulas', 'Inscricoes']);
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
            if ($this->Atividades->save($atividade)) {
                $this->Flash->success(__('The atividade has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The atividade could not be saved. Please, try again.'));
        }
        $projetos = $this->Atividades->Projetos->find('list', keyField: 'id', valueField: 'name')->toArray();
        $users = $this->Atividades->Users->find('list', keyField: 'id', valueField: 'name')->toArray();

        $this->set(compact('atividade', 'projetos', 'users'));
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
        $atividade = $this->Atividades->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $atividade = $this->Atividades->patchEntity($atividade, $this->request->getData());
            if ($this->Atividades->save($atividade)) {
                $this->Flash->success(__('The atividade has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The atividade could not be saved. Please, try again.'));
        }
        $projetos = $this->Atividades->Projetos->find('list', keyField: 'id', valueField: 'name')->toArray();
        $users = $this->Atividades->Users->find('list', keyField: 'id', valueField: 'name')->toArray();
        $this->set(compact('atividade', 'projetos', 'users'));
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
}
