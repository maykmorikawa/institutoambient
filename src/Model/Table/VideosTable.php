<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Videos Model
 *
 * @method \App\Model\Entity\Video newEmptyEntity()
 * @method \App\Model\Entity\Video newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Video> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Video get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Video findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Video patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Video> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Video|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Video saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Video>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Video>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Video>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Video> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Video>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Video>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Video>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Video> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VideosTable extends Table
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

        $this->setTable('videos');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('SystemLog'); // Assuming this exists as per PostsTable
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('video_url')
            ->maxLength('video_url', 255)
            ->requirePresence('video_url', 'create')
            ->notEmptyString('video_url');

        $validator
            ->scalar('background_image')
            ->maxLength('background_image', 255)
            ->allowEmptyString('background_image');

        return $validator;
    }
}
