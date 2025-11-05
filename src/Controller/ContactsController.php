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
        // 1. Verificar se a requisição é um POST
        if (!$this->request->is('post')) {
            // Lança uma exceção se não for um POST (boa prática)
            throw new MethodNotAllowedException();
        }
        
        // Pega os dados do formulário
        $data = $this->request->getData();
        
        // 2. Criar uma nova Entity e aplicar os dados
        $contact = $this->Contacts->newEmptyEntity();
        $contact = $this->Contacts->patchEntity($contact, $data);

        // 3. Tentar salvar no Banco de Dados
        if ($this->Contacts->save($contact)) {
            
            // --- DADOS SALVOS! Agora vamos tentar enviar o E-MAIL (Passo opcional, mas recomendado) ---
            try {
                $mailer = new Mailer('default');
                
                $mailer
                    // O EMAIL DE DESTINO do Instituto Ambiental
                    ->setTo('contato@institutoambient.org.br') 
                    
                    // Quem enviou
                    ->setFrom([$data['email'] => $data['name']]) 
                    
                    // O assunto do email
                    ->setSubject('CONTATO RECEBIDO (Salvo no BD) - ' . $data['subject']) 
                    
                    ->setEmailFormat('text') 
                    
                    // Corpo da mensagem (usando os dados da variável $data)
                    ->deliver("
                        Nome: {$data['name']}
                        Email: {$data['email']}
                        Telefone: {$data['phone']}
                        Assunto: {$data['subject']}
                        -------------------------
                        Mensagem:
                        {$data['message']}
                        -------------------------
                        * Esta mensagem foi salva no banco de dados.
                        Enviado em: " . Time::now()->toDateTimeString()
                    );
                
                // Sucesso no salvamento e no envio
                $this->Flash->success(__('Sua mensagem foi salva e enviada com sucesso! Em breve entraremos em contato.'));
                
            } catch (\Exception $e) {
                // Sucesso no salvamento, mas FALHA no envio do email
                $this->Flash->warning(__('Sua mensagem foi salva, mas ocorreu um erro ao enviar a notificação por e-mail. Entraremos em contato em breve.'));
                $this->log("Erro ao enviar email (salvo no BD): " . $e->getMessage(), 'error');
            }
            
        } else {
            // 4. Se a validação do modelo falhar (campos obrigatórios vazios, email inválido, etc.)
            $this->Flash->error(__('Houve um erro ao tentar salvar seu contato. Verifique se todos os campos obrigatórios foram preenchidos corretamente.'));
        }

        // 5. Redirecionar de volta para a página de contato
        return $this->redirect(['action' => 'index']);
    }
}