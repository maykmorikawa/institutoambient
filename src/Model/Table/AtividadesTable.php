<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\Utility\Text;
use Cake\Routing\Router;


/**
 * Atividades Model
 *
 * @property \App\Model\Table\ProjetosTable&\Cake\ORM\Association\BelongsTo $Projetos
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\AulasTable&\Cake\ORM\Association\HasMany $Aulas
 * @property \App\Model\Table\InscricoesTable&\Cake\ORM\Association\HasMany $Inscricoes
 *
 * @method \App\Model\Entity\Atividade newEmptyEntity()
 * @method \App\Model\Entity\Atividade newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Atividade> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Atividade get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Atividade findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Atividade patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Atividade> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Atividade|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Atividade saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Atividade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Atividade>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Atividade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Atividade> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Atividade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Atividade>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Atividade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Atividade> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AtividadesTable extends Table
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

        $this->setTable('atividades');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projetos', [
            'foreignKey' => 'projeto_id',
            'joinType' => 'INNER', // ou LEFT
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Aulas', [
            'foreignKey' => 'atividade_id',
        ]);
        $this->hasMany('Inscricoes', [
            'foreignKey' => 'atividade_id',
        ]);
        $this->hasMany('Alunos', [
            'foreignKey' => 'atividade_id',
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
            ->integer('projeto_id')
            ->allowEmptyString('projeto_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->notEmptyString('name');

        $validator
            ->scalar('descricao')
            ->allowEmptyString('descricao');

        $validator
            ->integer('vagas')
            ->notEmptyString('vagas');

        $validator
            ->scalar('local')
            ->maxLength('local', 100)
            ->allowEmptyString('local');

        $validator
            ->time('horario')
            ->allowEmptyTime('horario');

        $validator
            ->scalar('dias_semana')
            ->maxLength('dias_semana', 50)
            ->allowEmptyString('dias_semana');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->allowEmptyString('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('link_inscricao')
            ->maxLength('link_inscricao', 64)
            ->allowEmptyString('link_inscricao')
            ->add('link_inscricao', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['slug'], ['allowMultipleNulls' => true]), ['errorField' => 'slug']);
        $rules->add($rules->isUnique(['link_inscricao'], ['allowMultipleNulls' => true]), ['errorField' => 'link_inscricao']);
        $rules->add($rules->existsIn(['projeto_id'], 'Projetos'), ['errorField' => 'projeto_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }

    public function beforeSave(EventInterface $event, $entity, $options)
    {
        if (empty($entity->slug)) {
            $entity->slug = Text::slug(strtolower($entity->nome));
        }

        // Gera link PÚBLICO (sem /admin)
        $entity->link_inscricao = Router::url([
            'prefix' => false, 
            'controller' => 'Inscricoes',
            'action' => 'verificar',
            $entity->slug,
            '_full' => true  // Inclui o domínio completo
        ], false); // 👈 'false' remove prefixos (como /admin)

        return true;
    }
}
