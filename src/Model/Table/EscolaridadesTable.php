<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Escolaridades Model
 *
 * @property \App\Model\Table\AlunosTable&\Cake\ORM\Association\BelongsTo $Alunos
 *
 * @method \App\Model\Entity\Escolaridade newEmptyEntity()
 * @method \App\Model\Entity\Escolaridade newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Escolaridade> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Escolaridade get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Escolaridade findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Escolaridade patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Escolaridade> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Escolaridade|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Escolaridade saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Escolaridade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Escolaridade>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Escolaridade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Escolaridade> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Escolaridade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Escolaridade>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Escolaridade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Escolaridade> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EscolaridadesTable extends Table
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

        $this->setTable('escolaridades');
        $this->setDisplayField('nivel');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Alunos', [
            'foreignKey' => 'aluno_id',
            'joinType' => 'INNER',
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
            ->scalar('nivel')
            ->requirePresence('nivel', 'create')
            ->notEmptyString('nivel');

        $validator
            ->scalar('serie')
            ->maxLength('serie', 100)
            ->requirePresence('serie', 'create')
            ->notEmptyString('serie');

        $validator
            ->scalar('situacao')
            ->requirePresence('situacao', 'create')
            ->notEmptyString('situacao');

        $validator
            ->scalar('curso')
            ->maxLength('curso', 255)
            ->allowEmptyString('curso');

        $validator
            ->scalar('instituicao')
            ->maxLength('instituicao', 255)
            ->requirePresence('instituicao', 'create')
            ->notEmptyString('instituicao');

        $validator
            ->scalar('ano_conclusao')
            ->allowEmptyString('ano_conclusao');

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

        return $rules;
    }
}
