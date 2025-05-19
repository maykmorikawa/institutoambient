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
                'name' => 'Lorem ipsum dolor sit amet',
                'descricao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'data_inicio' => '2025-05-17',
                'data_fim' => '2025-05-17',
                'status' => 'Lorem ipsum dolor ',
                'user_id' => 1,
                'publicado' => 1,
                'created' => '2025-05-17 17:06:12',
                'modified' => '2025-05-17 17:06:12',
            ],
        ];
        parent::init();
    }
}
