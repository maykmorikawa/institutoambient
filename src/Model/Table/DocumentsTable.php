<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Documents Model
 *
 * @method \App\Model\Entity\Document newEmptyEntity()
 * @method \App\Model\Entity\Document newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Document> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Document get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Document findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Document patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Document> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Document|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Document saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Document>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Document>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Document>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Document> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Document>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Document>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Document>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Document> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DocumentsTable extends Table
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

        $this->setTable('documents');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        // Check if SystemLog exists before adding it
        if (class_exists('App\Model\Behavior\SystemLogBehavior')) {
            $this->addBehavior('SystemLog');
        }
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
            ->notEmptyString('title', 'O título é obrigatório.');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 255)
            ->allowEmptyString('filename');

        $validator
            ->scalar('category')
            ->maxLength('category', 50)
            ->requirePresence('category', 'create')
            ->notEmptyString('category');

        return $validator;
    }
}
