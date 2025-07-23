<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text; // Para gerar UUIDs

class CertificadosTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('certificados');
        $this->setDisplayField('codigo_autenticacao'); // Ou outro campo representativo
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Alunos', [
            'foreignKey' => 'aluno_id',
            'joinType' => 'INNER',
            'className' => 'Alunos',
        ]);
        $this->belongsTo('Atividades', [
            'foreignKey' => 'atividade_id',
            'joinType' => 'INNER',
            'className' => 'Atividades',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('aluno_id')
            ->requirePresence('aluno_id', 'create')
            ->notEmptyString('aluno_id');

        $validator
            ->integer('atividade_id')
            ->requirePresence('atividade_id', 'create')
            ->notEmptyString('atividade_id');

        $validator
            ->scalar('codigo_autenticacao')
            ->maxLength('codigo_autenticacao', 255)
            ->requirePresence('codigo_autenticacao', 'create')
            ->notEmptyString('codigo_autenticacao')
            ->add('codigo_autenticacao', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Este código de autenticação já existe.']);

        $validator
            ->integer('carga_horaria_total')
            ->requirePresence('carga_horaria_total', 'create')
            ->notEmptyString('carga_horaria_total');

        $validator
            ->date('data_emissao')
            ->requirePresence('data_emissao', 'create')
            ->notEmptyDate('data_emissao');

        return $validator;
    }

    /**
     * Callback beforeSave para gerar o código de autenticação se for um novo registro.
     *
     * @param \Cake\Event\EventInterface $event The beforeSave event.
     * @param \App\Model\Entity\Certificado $entity The entity to be saved.
     * @param \ArrayObject $options The options for the save operation.
     * @return bool
     */
    public function beforeSave(EventInterface $event, $entity, \ArrayObject $options)
    {
        if ($entity->isNew() && empty($entity->codigo_autenticacao)) {
            $entity->codigo_autenticacao = Text::uuid(); // Gera um UUID único
        }
        return true;
    }
}