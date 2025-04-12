<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\EventInterface;

class AppController extends AppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        $user = $this->request->getAttribute('identity');

        if (!$user || $user->profile_id !== 1) {
            $this->Flash->error('Acesso não autorizado.');
            return $this->redirect('/');
        }
    }
}
