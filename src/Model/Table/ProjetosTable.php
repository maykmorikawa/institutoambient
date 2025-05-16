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
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->requirePresence('titulo', 'create')
            ->notEmptyString('titulo');

        $validator
            ->boolean('publicado')
            ->allowEmptyString('publicado');

        return $validator;
    }
}
