<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MappingStaff extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nip_staff' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true
            ],
            'nama_staff' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'fk_kaur' => [ 
                'type' => 'INT',
                'unsigned' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('fk_kaur', 'kaurs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('staffs');
    }

    public function down()
    {
        $this->forge->dropTable('staffs');
    }
}