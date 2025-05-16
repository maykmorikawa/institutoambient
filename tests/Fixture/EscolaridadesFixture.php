<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EscolaridadesFixture
 */
class EscolaridadesFixture extends TestFixture
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
                'nivel' => 'Lorem ipsum dolor sit amet',
                'serie' => 'Lorem ipsum dolor sit amet',
                'situacao' => 'Lorem ipsum dolor sit amet',
                'curso' => 'Lorem ipsum dolor sit amet',
                'instituicao' => 'Lorem ipsum dolor sit amet',
                'ano_conclusao' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-05-16 00:09:45',
                'modified' => '2025-05-16 00:09:45',
            ],
        ];
        parent::init();
    }
}
