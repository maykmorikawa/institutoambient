<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Aulas Model
 *
 * @property \App\Model\Table\AtividadesTable&\Cake\ORM\Association\BelongsTo $Atividades
 * @property \App\Model\Table\PresencasTable&\Cake\ORM\Association\HasMany $Presencas
 *
 * @method \App\Model\Entity\Aula newEmptyEntity()
 * @method \App\Model\Entity\Aula newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Aula> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Aula get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Aula findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Aula patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Aula> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Aula|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Aula saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Aula>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Aula>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Aula>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Aula> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Aula>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Aula>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Aula>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Aula> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AulasTable extends Table
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

        $this->setTable('aulas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Atividades', [
            'foreignKey' => 'atividade_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Presencas', [
            'foreignKey' => 'aula_id',
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
            ->integer('atividade_id')
            ->notEmptyString('atividade_id');

        $validator
            ->dateTime('data')
            ->requirePresence('data', 'create')
            ->notEmptyDateTime('data');

        $validator
            ->scalar('conteudo')
            ->allowEmptyString('conteudo');

        $validator
            ->scalar('observacoes')
            ->allowEmptyString('observacoes');

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
        $rules->add($rules->existsIn(['atividade_id'], 'Atividades'), ['errorField' => 'atividade_id']);

        return $rules;
    }
}
