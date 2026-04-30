<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateVideos extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('videos');
        $table->addColumn('title', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('video_url', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('background_image', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('created', 'datetime', ['null' => true])
              ->addColumn('modified', 'datetime', ['null' => true])
              ->create();
    }
}
