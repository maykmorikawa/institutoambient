<?php

declare(strict_types=1);

namespace App\Controller\Admin;



/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->Authentication->allowUnauthenticated(['login']);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);

        // Permitir acesso a login, logout e add sem autenticação
        $this->Authentication->addUnauthenticatedActions(['login', 'logout', 'add']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function admin()
    {
    }


    public function login()
    {
        $this->viewBuilder()->setLayout('login');
        // Se o usuário já estiver logado, redireciona para a página inicial
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid() && $this->request->is('get')) {
            return $this->redirect([
                'controller' => 'Users',
                'action' => 'admin',
            ]);
        }

        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Users',
                'action' => 'admin',
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
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
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
        $this->viewBuilder()->setLayout('admin');

        $user = $this->Users->get($id, contain: []);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // 🔐 Se a senha estiver vazia, não atualiza
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('O usuário foi atualizado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Não foi possível atualizar o usuário. Por favor, tente novamente.'));
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

        // Obtém o usuário logado
        $currentUser = $this->Authentication->getIdentity();

        // --- VERIFICA SE É SUPER-ADMIN (profile_id == 1) ---
        if ($currentUser->profile_id != 1) {
            $this->Flash->error(__('Apenas o super-admin pode excluir usuários.'));
            return $this->redirect(['action' => 'index']);
        }

        // Obtém o usuário que será excluído
        $userToDelete = $this->Users->get($id);

        // --- REGISTRA LOG DE AUDITORIA ANTES DE EXCLUIR ---
        $this->logAuditDelete($currentUser, $userToDelete);

        // Tenta excluir
        if ($this->Users->delete($userToDelete)) {
            $this->Flash->success(__('Usuário excluído com sucesso.'));
        } else {
            $this->Flash->error(__('Falha ao excluir. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Registra no log quem excluiu qual usuário.
     */
    private function logAuditDelete($currentUser, $deletedUser)
    {
        $logMessage = sprintf(
            '[AUDITORIA] Super-Admin ID %s (%s) excluiu o usuário ID %s (%s) em %s',
            $currentUser->id,
            $currentUser->email,
            $deletedUser->id,
            $deletedUser->email,
            date('Y-m-d H:i:s')
        );

        // Salva no arquivo de logs do CakePHP (logs/audit.log)
        Log::write('info', $logMessage, ['scope' => ['audit']]);
    }
    

}
