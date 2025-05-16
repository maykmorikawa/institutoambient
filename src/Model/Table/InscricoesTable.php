<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Inscricoes Model
 *
 * @property \App\Model\Table\AlunosTable&\Cake\ORM\Association\BelongsTo $Alunos
 * @property \App\Model\Table\AtividadesTable&\Cake\ORM\Association\BelongsTo $Atividades
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Responsavels
 *
 * @method \App\Model\Entity\Inscrico newEmptyEntity()
 * @method \App\Model\Entity\Inscrico newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Inscrico> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Inscrico get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Inscrico findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Inscrico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Inscrico> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Inscrico|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Inscrico saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Inscrico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inscrico>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inscrico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inscrico> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inscrico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inscrico>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inscrico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inscrico> deleteManyOrFail(iterable $entities, array $options = [])
 */
class InscricoesTable extends Table
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

        $this->setTable('inscricoes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Alunos', [
            'foreignKey' => 'aluno_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Atividades', [
            'foreignKey' => 'atividade_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Responsavels', [
            'foreignKey' => 'responsavel_id',
            'className' => 'Users',
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
            ->integer('aluno_id')
            ->notEmptyString('aluno_id');

        $validator
            ->integer('atividade_id')
            ->notEmptyString('atividade_id');

        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id');

        $validator
            ->integer('responsavel_id')
            ->allowEmptyString('responsavel_id');

        $validator
            ->dateTime('data_inscricao')
            ->allowEmptyDateTime('data_inscricao');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['aluno_id'], 'Alunos'), ['errorField' => 'aluno_id']);
        $rules->add($rules->existsIn(['atividade_id'], 'Atividades'), ['errorField' => 'atividade_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['responsavel_id'], 'Responsavels'), ['errorField' => 'responsavel_id']);

        return $rules;
    }
}
