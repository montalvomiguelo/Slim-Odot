<?php

use Phinx\Migration\AbstractMigration;

class CreateTodoItemsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {

        $table = $this->table('todo_items');

        $table->addcolumn('title', 'string')
              ->addColumn('todo_list_id', 'integer')
              ->addForeignKey('todo_list_id', 'todo_lists', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->create();
    }
}
