<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProjetosFixture
 */
class ProjetosFixture extends TestFixture
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
                'titulo' => 'Lorem ipsum dolor sit amet',
                'ublicado' => 1,
                'created' => '2025-05-16 02:29:37',
                'modified' => '2025-05-16 02:29:37',
            ],
        ];
        parent::init();
    }
}
