<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController as BaseController; // 👈 ALIAS aqui
use Cake\Event\EventInterface;

class AppController extends BaseController // 👈 agora extende o alias
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');

        // Permitir acesso à tela de login sem verificação de perfil
        if ($this->request->getParam('action') === 'login') {
            return null;
        }

        $user = $this->request->getAttribute('identity');

        if (!$user || $user->get('profile_id') !== 1) {
            $this->Flash->error('Acesso não autorizado.');
            return $this->redirect('/');
        }
    }
}
