<?php
// src/Model/Table/ContactsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ContactsTable extends Table
{
    /**
     * Inicializa o esquema de Tabela.
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('contacts'); // Define o nome da tabela no BD
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        // Adiciona os Behaviors 'Timestamp' para created e modified
        $this->addBehavior('Timestamp'); 
    }

    /**
     * Define as regras de validação para os campos do formulário.
     */
    public function validationDefault(Validator $validator): Validator
    {
        // Regras para os campos obrigatórios (name, email, subject, message)
        $validator
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'O nome é obrigatório.');

        $validator
            ->email('email', false, 'Forneça um endereço de e-mail válido.')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'O e-mail é obrigatório.');
            
        $validator
            ->requirePresence('subject', 'create')
            ->notEmptyString('subject', 'O assunto é obrigatório.');

        $validator
            ->requirePresence('message', 'create')
            ->notEmptyString('message', 'A mensagem é obrigatória.');
        
        // Campo 'phone' não é obrigatório, mas pode ter regras se necessário.

        return $validator;
    }
}