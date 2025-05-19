<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Projetos Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\AtividadesTable&\Cake\ORM\Association\HasMany $Atividades
 *
 * @method \App\Model\Entity\Projeto newEmptyEntity()
 * @method \App\Model\Entity\Projeto newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Projeto> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Projeto get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Projeto findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Projeto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Projeto> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Projeto|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Projeto saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Projeto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Projeto>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Projeto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Projeto> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Projeto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Projeto>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Projeto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Projeto> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProjetosTable extends Table
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

        $this->setTable('projetos');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Atividades', [
            'foreignKey' => 'projeto_id',
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
            ->scalar('name')
            ->maxLength('name', 100)
            ->notEmptyString('name');

        $validator
            ->scalar('descricao')
            ->allowEmptyString('descricao');

        $validator
            ->date('data_inicio')
            ->requirePresence('data_inicio', 'create')
            ->notEmptyDate('data_inicio');

        $validator
            ->date('data_fim')
            ->requirePresence('data_fim', 'create')
            ->notEmptyDate('data_fim');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->boolean('publicado')
            ->allowEmptyString('publicado');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
