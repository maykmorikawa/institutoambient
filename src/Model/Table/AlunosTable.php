<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Alunos Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\HasMany $Enderecos
 * @property \App\Model\Table\EscolaridadesTable&\Cake\ORM\Association\HasMany $Escolaridades
 * @property \App\Model\Table\InscricoesTable&\Cake\ORM\Association\HasMany $Inscricoes
 * @property \App\Model\Table\PresencasTable&\Cake\ORM\Association\HasMany $Presencas
 *
 * @method \App\Model\Entity\Aluno newEmptyEntity()
 * @method \App\Model\Entity\Aluno newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Aluno> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Aluno get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Aluno findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Aluno patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Aluno> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Aluno|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Aluno saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Aluno>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Aluno>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Aluno>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Aluno> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Aluno>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Aluno>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Aluno>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Aluno> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AlunosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('alunos');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('Inscricoes', [
            'foreignKey' => 'aluno_id',
        ]);
        $this->hasMany('Presencas', [
            'foreignKey' => 'aluno_id',
        ]);

        $this->hasMany('Enderecos', [
            'foreignKey' => 'aluno_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);

        $this->hasMany('Escolaridades', [
            'foreignKey' => 'aluno_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->scalar('nome_completo')
            ->maxLength('nome_completo', 100)
            ->requirePresence('nome_completo', 'create')
            ->notEmptyString('nome_completo');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            // Validação CPF
            ->add('cpf', 'length', [
                'rule' => ['lengthBetween', 11, 14],
                'message' => 'CPF deve conter 11 dígitos'
            ])
            ->add('cpf', 'custom', [
                'rule' => function ($value) {
                    $cleaned = preg_replace('/[^0-9]/', '', $value);
                    return strlen($cleaned) === 11;
                },
                'message' => 'CPF inválido'
            ]);

        $validator
            ->scalar('rg')
            ->maxLength('rg', 20)
            ->allowEmptyString('rg');

        $validator
            ->scalar('nis')
            ->maxLength('nis', 20)
            ->allowEmptyString('nis');

        $validator
            ->date('data_nascimento')
            ->allowEmptyDate('data_nascimento');

        $validator
            // Validação Telefone
            ->add('telefone', 'custom', [
                'rule' => function ($value) {
                    $cleaned = preg_replace('/[^0-9]/', '', $value);
                    return strlen($cleaned) >= 10 && strlen($cleaned) <= 11;
                },
                'message' => 'Telefone deve ter 10 ou 11 dígitos'
            ]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['cpf']), ['errorField' => 'cpf']);
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
