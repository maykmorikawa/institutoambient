<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
        
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $identity = $this->Authentication->getIdentity();
        if ($identity) {
            \Cake\Core\Configure::write('CurrentUser', $identity->getIdentifier());
        }

        // Liberar acesso à página pública
        $this->Authentication->addUnauthenticatedActions([
            'display',
            'home',
            'noticia',
            'listblog',
            'tag',
            'view',
            'captacao',
            'listprojetos',
            'documentos',
            'manutencao' // libera /pages/display/*, inclusive /pages/home
        ]);
    }
}
