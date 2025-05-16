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
 * @property \App\Model\Table\AtividadesTable&\Cake\ORM\Association\BelongsTo $Atividades
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\HasMany $Enderecos
 * @property \App\Model\Table\EscolaridadesTable&\Cake\ORM\Association\HasMany $Escolaridades
 * @property \App\Model\Table\InscricoesTable&\Cake\ORM\Association\HasMany $Inscricoes
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

        $this->belongsTo('Atividades', [
            'foreignKey' => 'atividade_id',
        ]);
        $this->hasMany('Enderecos', [
            'foreignKey' => 'aluno_id',
        ]);
        $this->hasMany('Escolaridades', [
            'foreignKey' => 'aluno_id',
        ]);
        $this->hasMany('Inscricoes', [
            'foreignKey' => 'aluno_id',
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
            ->scalar('nome')
            ->maxLength('nome', 255)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('cpf')
            ->maxLength('cpf', 14)
            ->requirePresence('cpf', 'create')
            ->notEmptyString('cpf')
            ->add('cpf', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
            ->scalar('telefone')
            ->maxLength('telefone', 20)
            ->allowEmptyString('telefone');

        $validator
            ->integer('atividade_id')
            ->allowEmptyString('atividade_id');

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
        $rules->add($rules->existsIn(['atividade_id'], 'Atividades'), ['errorField' => 'atividade_id']);

        return $rules;
    }
}
