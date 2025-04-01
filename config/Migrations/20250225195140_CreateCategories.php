<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateCategories extends AbstractMigration
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
    $table = $this->table('categories');
    $table->addColumn('name', 'string', ['limit' => 255, 'null' => false])
          ->addColumn('slug', 'string', ['limit' => 255, 'null' => false])
          ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
}

}
