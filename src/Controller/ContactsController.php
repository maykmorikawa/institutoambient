<?php

declare(strict_types=1);

namespace App\Controller;

class ContactsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

      
      

        // Permite acesso público (caso esteja usando Authentication)
        $this->Authentication?->allowUnauthenticated(['index', 'enviar']);
    }

    public function index()
    {
       $this->viewBuilder()->setLayout('site');
    }

    public function enviar()
    {
        if ($this->request->is('post')) {
            $contact = $this->Contacts->newEmptyEntity();
            $contact = $this->Contacts->patchEntity($contact, $this->request->getData());

            if ($this->Contacts->save($contact)) {
                $this->Flash->success('Mensagem enviada com sucesso!');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Não foi possível enviar sua mensagem. Tente novamente.');
        }

        return $this->redirect(['action' => 'index']);
    }
}
