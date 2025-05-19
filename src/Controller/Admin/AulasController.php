<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Aulas Controller
 *
 * @property \App\Model\Table\AulasTable $Aulas
 */
class AulasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Aulas->find()
            ->contain(['Atividades']);
        $aulas = $this->paginate($query);

        $this->set(compact('aulas'));
    }

    /**
     * View method
     *
     * @param string|null $id Aula id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $aula = $this->Aulas->get($id, contain: ['Atividades', 'Presencas']);
        $this->set(compact('aula'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $aula = $this->Aulas->newEmptyEntity();
        if ($this->request->is('post')) {
            $aula = $this->Aulas->patchEntity($aula, $this->request->getData());
            if ($this->Aulas->save($aula)) {
                $this->Flash->success(__('The aula has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The aula could not be saved. Please, try again.'));
        }
        $atividades = $this->Aulas->Atividades->find('list', limit: 200)->all();
        $this->set(compact('aula', 'atividades'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Aula id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $aula = $this->Aulas->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $aula = $this->Aulas->patchEntity($aula, $this->request->getData());
            if ($this->Aulas->save($aula)) {
                $this->Flash->success(__('The aula has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The aula could not be saved. Please, try again.'));
        }
        $atividades = $this->Aulas->Atividades->find('list', limit: 200)->all();
        $this->set(compact('aula', 'atividades'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Aula id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $aula = $this->Aulas->get($id);
        if ($this->Aulas->delete($aula)) {
            $this->Flash->success(__('The aula has been deleted.'));
        } else {
            $this->Flash->error(__('The aula could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
