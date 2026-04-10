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
            'kaur_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'nip_kaur' =>  [
                'type'  => 'INT',
                'constraint'  =>  5,
                'unsigned'  =>  true
            ],
            'flag' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
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
