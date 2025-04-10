<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{


    public function login()
    {
        $this->viewBuilder()->setLayout('login');

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);

                // Verifica se o profile_id é 3
                if ($user['profile_id'] == 3) {
                    // Extrai os links do campo view_links, separando por ponto
                    $authorizedLinks = explode('.', $user['view_links']);

                    // Pega o primeiro link da lista (assumindo que é numérico)
                    $firstLink = intval($authorizedLinks[0]);

                    // Verifica se o primeiro link é válido antes de redirecionar
                    if ($firstLink > 0) {
                        // Redireciona para a view do primeiro link
                        return $this->redirect(['controller' => 'Links', 'action' => 'viewdigitador', $firstLink]);
                    } else {
                        $this->Flash->error(__('Nenhum link válido associado.'));
                        return $this->redirect($this->Auth->redirectUrl('/'));
                    }
                }

                // Para outros usuários, redireciona para a URL padrão
                return $this->redirect($this->Auth->redirectUrl('/'));
            } else {
                $this->Flash->error(__('Dados incorretos para o acesso.'));
            }
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find()
            ->contain(['Profiles']);
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: ['Profiles', 'Posts']);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                // Redireciona para StudentsController/add com user_id na URL
                return $this->redirect([
                    'controller' => 'Students',
                    'action' => 'add',
                    '?' => ['user_id' => $user->id] // passa como query string
                ]);
            }

            $this->Flash->error(__('Erro ao salvar o usuário. Tente novamente.'));
        }

        $this->set(compact('user'));
    }


    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $profiles = $this->Users->Profiles->find('list', limit: 200)->all();
        $this->set(compact('user', 'profiles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
