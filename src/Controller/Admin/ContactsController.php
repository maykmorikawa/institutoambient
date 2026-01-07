<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class ContactsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // Aqui podes adicionar lógica de autenticação 
        // para garantir que só o admin acede a esta classe
    }

    public function checkNewMessages()
    {
        $this->viewBuilder()->setClassName('Json');

        // Carregamos o model Contacts (que não está na pasta Admin, mas na raiz)
        $this->fetchTable('Contacts');

        $count = $this->Contacts->find()
            ->where(['viewed' => 0])
            ->count();

        $messages = $this->Contacts->find()
            ->select(['id', 'name', 'subject', 'created'])
            ->where(['viewed' => 0])
            ->order(['created' => 'DESC'])
            ->limit(5)
            ->toArray();

        $this->set(compact('count', 'messages'));
        $this->viewBuilder()->setOption('serialize', ['count', 'messages']);
    }

    public function view($id = null)
    {
        $contact = $this->Contacts->get($id);
        
        // Quando o admin visualiza, marcamos como lida
        $contact->viewed = 1;
        $this->Contacts->save($contact);

        $this->set(compact('contact'));
    }
}