<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Projetos Controller
 *
 * @property \App\Model\Table\ProjetosTable $Projetos
 */
class ProjetosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Projetos->find();
        $projetos = $this->paginate($query);

        $this->set(compact('projetos'));
    }

    /**
     * View method
     *
     * @param string|null $id Projeto id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projeto = $this->Projetos->get($id, contain: ['Atividades']);
        $this->set(compact('projeto'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projeto = $this->Projetos->newEmptyEntity();
        if ($this->request->is('post')) {
            $projeto = $this->Projetos->patchEntity($projeto, $this->request->getData());
            if ($this->Projetos->save($projeto)) {
                $this->Flash->success(__('The projeto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projeto could not be saved. Please, try again.'));
        }
        $this->set(compact('projeto'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Projeto id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projeto = $this->Projetos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projeto = $this->Projetos->patchEntity($projeto, $this->request->getData());
            if ($this->Projetos->save($projeto)) {
                $this->Flash->success(__('The projeto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projeto could not be saved. Please, try again.'));
        }
        $this->set(compact('projeto'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Projeto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projeto = $this->Projetos->get($id);
        if ($this->Projetos->delete($projeto)) {
            $this->Flash->success(__('The projeto has been deleted.'));
        } else {
            $this->Flash->error(__('The projeto could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
