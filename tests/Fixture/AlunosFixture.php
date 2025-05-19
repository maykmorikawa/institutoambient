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
                'user_id' => 1,
                'nome_completo' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'cpf' => 'Lorem ipsum ',
                'rg' => 'Lorem ipsum dolor ',
                'nis' => 'Lorem ipsum dolor ',
                'data_nascimento' => '2025-05-16',
                'telefone' => 'Lorem ipsum dolor ',
                'created' => '2025-05-16 23:01:14',
                'modified' => '2025-05-16 23:01:14',
            ],
        ];
        parent::init();
    }
}
