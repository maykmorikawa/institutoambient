<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController as BaseController; // 👈 ALIAS aqui
use Cake\Event\EventInterface;

class AppController extends BaseController // 👈 agora extende o alias
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
        $user = $this->request->getAttribute('identity');

        if (!$user || $user->profile_id !== 1) {
            $this->Flash->error('Acesso não autorizado.');
            $this->redirect('/');
        }
    }
}
