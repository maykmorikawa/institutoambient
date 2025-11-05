<?php

namespace App\Controller;

use Cake\Mailer\Mailer;
use Cake\I18n\Time;
use Cake\Http\Exception\MethodNotAllowedException; // Usar para métodos não permitidos

class ContactsController extends AppController
{
    // O CakePHP 4+ exige que você chame o loadModel,
    // ou defina $this->loadModel('Contacts') na initialize().
    public function initialize(): void
    {
        parent::initialize();
        // Garante que o modelo Contacts estará disponível no Controller
        $this->loadModel('Contacts');
    }

    public function index()
    {
        // Esta action apenas renderiza a view
    }

    /**
     * Action responsável por salvar os dados no BD e enviar o e-mail.
     */
    public function enviar()
    {
        if ($this->request->is('post')) {
            $contact = $this->Contacts->newEntity($this->request->getData());
            if ($this->Contacts->save($contact)) {
                $this->Flash->success('Mensagem enviada com sucesso!');
            } else {
                $this->Flash->error('Não foi possível enviar sua mensagem. Tente novamente.');
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
