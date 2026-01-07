<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class ContactsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->fetchTable('Contacts'); // Garante que o controller usa a tabela certa
    }
       

    public function index()
    {
        // Paginação para não carregar tudo de uma vez se tiveres muitas mensagens
        $query = $this->Contacts->find()->order(['created' => 'DESC']);
        $contacts = $this->paginate($query);

        $this->set(compact('contacts'));
    }

    // Ver uma mensagem detalhada
    public function view($id = null)
    {
        $contact = $this->Contacts->get($id);

        // Lógica importante: Ao abrir a mensagem, marcamos como lida (viewed = 1)
        if ($contact->viewed == 0) {
            $contact->viewed = 1;
            $this->Contacts->save($contact);
        }

        $this->set(compact('contact'));
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

   
}