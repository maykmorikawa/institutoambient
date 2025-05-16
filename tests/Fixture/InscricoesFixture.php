<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InscricoesFixture
 */
class InscricoesFixture extends TestFixture
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
                'aluno_id' => 1,
                'atividade_id' => 1,
                'user_id' => 1,
                'responsavel_id' => 1,
                'data_inscricao' => '2025-05-16 02:33:44',
                'status' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
