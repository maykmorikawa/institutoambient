<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PostImages Model
 *
 * @property \App\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \App\Model\Entity\PostImage newEmptyEntity()
 * @method \App\Model\Entity\PostImage newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PostImage> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PostImage get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PostImage findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PostImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PostImage> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PostImage|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PostImage saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PostImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PostImage>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PostImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PostImage> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PostImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PostImage>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PostImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PostImage> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostImagesTable extends Table
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

        $this->setTable('post_images');
        $this->setDisplayField('filename');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
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
            ->integer('post_id')
            ->notEmptyString('post_id');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 255)
            ->requirePresence('filename', 'create')
            ->notEmptyString('filename');

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
        $rules->add($rules->existsIn(['post_id'], 'Posts'), ['errorField' => 'post_id']);

        return $rules;
    }
}
