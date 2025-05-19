<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AtividadesFixture
 */
class AtividadesFixture extends TestFixture
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
                'projeto_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'descricao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'vagas' => 1,
                'local' => 'Lorem ipsum dolor sit amet',
                'horario' => '16:27:36',
                'dias_semana' => 'Lorem ipsum dolor sit amet',
                'user_id' => 1,
                'slug' => 'Lorem ipsum dolor sit amet',
                'link_inscricao' => 'Lorem ipsum dolor sit amet',
                'publicado' => 1,
                'created' => '2025-05-17 16:27:36',
                'modified' => '2025-05-17 16:27:36',
            ],
        ];
        parent::init();
    }
}
