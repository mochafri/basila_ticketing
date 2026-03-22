<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AssignTiket extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'assign_task_to_kabag' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'user_id_kabag' =>  [
                'type'  => 'INT',
                'constraint'  =>  5,
                'unsigned'  =>  true
            ],
            'fk_tiket' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('assign_tiket');
        $this->forge->addForeignKey('fk_tiket', 'tikets', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('assign_tiket');
    }
}
