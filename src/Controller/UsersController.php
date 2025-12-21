<?php


declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;



/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // Permitir acesso a login, logout e add sem autenticação
        $this->Authentication->addUnauthenticatedActions(['login', 'logout', 'add']);
    }


    public function login()
    {
        // Se o usuário já estiver logado, redireciona para a página inicial
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid() && $this->request->is('get')) {
            return $this->redirect([
                'controller' => 'Pages',
                'action' => 'display',
                'home',
            ]);
        }

        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Pages',
                'action' => 'display',
                'home',
            ]);
            return $this->redirect($redirect);
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Email ou senha inválidos.');
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success('Você saiu com sucesso.');
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        } else {
            $this->Flash->error('Você não está logado.');
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
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
                $this->Flash->success(__('Usuário cadastrado com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível cadastrar o usuário. Por favor, tente novamente.'));
        }
        $profiles = $this->Users->Profiles->find('list', limit: 200)->all();
        $this->set(compact('user', 'profiles'));
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
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // 🔐 Se a senha estiver vazia, não atualiza
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário atualizado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao atualizar o usuário.'));
        }
        $profiles = $this->Users->Profiles->find('list')->limit(200);
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
            $this->Flash->success(__('O usuário foi deletado com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível deletar o usuário. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
