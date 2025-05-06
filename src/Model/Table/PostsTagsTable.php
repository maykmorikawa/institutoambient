<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PostsTags Model
 *
 * @property \App\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\PostsTag newEmptyEntity()
 * @method \App\Model\Entity\PostsTag newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PostsTag> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PostsTag get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PostsTag findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PostsTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PostsTag> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PostsTag|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PostsTag saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PostsTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PostsTag>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PostsTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PostsTag> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PostsTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PostsTag>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PostsTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PostsTag> deleteManyOrFail(iterable $entities, array $options = [])
 */
class PostsTagsTable extends Table
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

        $this->setTable('posts_tags');
        $this->setDisplayField(['post_id', 'tag_id']);
        $this->setPrimaryKey(['post_id', 'tag_id']);

        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
            'joinType' => 'INNER',
        ]);
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
        $rules->add($rules->existsIn(['tag_id'], 'Tags'), ['errorField' => 'tag_id']);

        return $rules;
    }
}
