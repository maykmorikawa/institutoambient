<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AlunosFixture
 */
class AlunosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'nome' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'cpf' => 'Lorem ipsum ',
                'rg' => 'Lorem ipsum dolor ',
                'nis' => 'Lorem ipsum dolor ',
                'data_nascimento' => '2025-05-16',
                'telefone' => 'Lorem ipsum dolor ',
                'created' => '2025-05-16 01:19:34',
                'modified' => '2025-05-16 01:19:34',
                'atividade_id' => 1,
            ],
        ];
        parent::init();
    }
}
