<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateComments extends AbstractMigration
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
        $table = $this->table('comments');
        $table->addColumn('post_id', 'integer', ['null' => false])
            ->addColumn('user_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('user_email', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('content', 'text', ['null' => false])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('post_id', 'posts', 'id', ['delete' => 'CASCADE'])
            ->create();
    }
}
