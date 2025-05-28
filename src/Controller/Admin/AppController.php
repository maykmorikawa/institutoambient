<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;

class AppController extends BaseController
{
    public function initialize(): void
    {
        parent::initialize();

        // Aqui NÃO precisa do allowUnauthenticated
        // Ele não existe no componente Authentication
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        $this->viewBuilder()->setLayout('admin');
        $this->Authentication->addUnauthenticatedActions(['login', 'logout', 'add']);

        $user = $this->request->getAttribute('identity');

        // Lista de controllers que exigem perfil de admin
        $controllersComRestricao = ['Users', 'Cursos', 'Projetos'];

        $currentController = $this->request->getParam('controller');

        if (in_array($currentController, $controllersComRestricao)) {
            if (!$user || $user->profile_id !== 1) {
                $this->Flash->error('Acesso não autorizado.');
                $this->redirect('/');
            }
        }
    }

    public function admin()
    {
    }
}
