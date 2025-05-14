<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PostImagesFixture
 */
class PostImagesFixture extends TestFixture
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
                'post_id' => 1,
                'filename' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-05-14 19:10:11',
            ],
        ];
        parent::init();
    }
}
