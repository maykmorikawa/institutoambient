<?php
// src/Model/Table/SettingsTable.php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SettingsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('settings');
        $this->setDisplayField('key_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('key_name')
            ->maxLength('key_name', 255)
            ->requirePresence('key_name', 'create')
            ->notEmptyString('key_name')
            ->add('key_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('value')
            ->allowEmptyString('value');

        $validator
            ->scalar('type')
            ->maxLength('type', 50)
            ->notEmptyString('type');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['key_name']), ['errorField' => 'key_name']);

        return $rules;
    }
}