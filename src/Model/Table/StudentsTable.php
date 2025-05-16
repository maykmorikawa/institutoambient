<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Students Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Student newEmptyEntity()
 * @method \App\Model\Entity\Student newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Student> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Student get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Student findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Student patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Student> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Student|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Student saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Student>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Student>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Student>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Student> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Student>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Student>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Student>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Student> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StudentsTable extends Table
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

        $this->setTable('students');
        $this->setDisplayField('genero');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->date('data_nascimento')
            ->requirePresence('data_nascimento', 'create')
            ->notEmptyDate('data_nascimento');

        $validator
            ->scalar('genero')
            ->maxLength('genero', 50)
            ->requirePresence('genero', 'create')
            ->notEmptyString('genero');

        $validator
            ->scalar('estado_civil')
            ->maxLength('estado_civil', 50)
            ->requirePresence('estado_civil', 'create')
            ->notEmptyString('estado_civil');

        $validator
            ->scalar('religiao')
            ->maxLength('religiao', 100)
            ->requirePresence('religiao', 'create')
            ->notEmptyString('religiao');

        $validator
            ->scalar('naturalidade')
            ->maxLength('naturalidade', 100)
            ->requirePresence('naturalidade', 'create')
            ->notEmptyString('naturalidade');

        $validator
            ->scalar('cor_etnia')
            ->maxLength('cor_etnia', 50)
            ->requirePresence('cor_etnia', 'create')
            ->notEmptyString('cor_etnia');

        $validator
            ->scalar('rg')
            ->maxLength('rg', 20)
            ->allowEmptyString('rg');

        $validator
            ->scalar('nis')
            ->maxLength('nis', 50)
            ->requirePresence('nis', 'create')
            ->notEmptyString('nis');

        $validator
            ->scalar('documentos_civis')
            ->allowEmptyString('documentos_civis');

        $validator
            ->scalar('programas_sociais')
            ->allowEmptyString('programas_sociais');

        $validator
            ->scalar('valor_beneficio')
            ->maxLength('valor_beneficio', 20)
            ->allowEmptyString('valor_beneficio');

        $validator
            ->scalar('cadunico_codigo')
            ->maxLength('cadunico_codigo', 50)
            ->allowEmptyString('cadunico_codigo');

        $validator
            ->scalar('cep')
            ->maxLength('cep', 9)
            ->requirePresence('cep', 'create')
            ->notEmptyString('cep');

        $validator
            ->scalar('endereco')
            ->maxLength('endereco', 255)
            ->requirePresence('endereco', 'create')
            ->notEmptyString('endereco');

        $validator
            ->scalar('municipio')
            ->maxLength('municipio', 100)
            ->requirePresence('municipio', 'create')
            ->notEmptyString('municipio');

        $validator
            ->boolean('pessoa_com_deficiencia')
            ->requirePresence('pessoa_com_deficiencia', 'create')
            ->notEmptyString('pessoa_com_deficiencia');

        $validator
            ->scalar('tipo_deficiencia')
            ->maxLength('tipo_deficiencia', 255)
            ->allowEmptyString('tipo_deficiencia');

        $validator
            ->scalar('serie_estudada')
            ->maxLength('serie_estudada', 100)
            ->requirePresence('serie_estudada', 'create')
            ->notEmptyString('serie_estudada');

        $validator
            ->scalar('situacao_escolar')
            ->maxLength('situacao_escolar', 50)
            ->requirePresence('situacao_escolar', 'create')
            ->notEmptyString('situacao_escolar');

        $validator
            ->scalar('instituicao_ensino')
            ->maxLength('instituicao_ensino', 255)
            ->requirePresence('instituicao_ensino', 'create')
            ->notEmptyString('instituicao_ensino');

        $validator
            ->scalar('encaminhado_por')
            ->allowEmptyString('encaminhado_por');

        $validator
            ->scalar('turma')
            ->maxLength('turma', 255)
            ->requirePresence('turma', 'create')
            ->notEmptyString('turma');

        $validator
            ->boolean('autorizo_imagem')
            ->requirePresence('autorizo_imagem', 'create')
            ->notEmptyString('autorizo_imagem');

        $validator
            ->boolean('compromisso_social')
            ->requirePresence('compromisso_social', 'create')
            ->notEmptyString('compromisso_social');

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
