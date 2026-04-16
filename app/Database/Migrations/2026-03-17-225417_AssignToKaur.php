<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AssignToKaur extends Migration
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
                'type' => 'ENUM',
                'constraint' => ['Start', 'Finish'],
                'null' => true
            ],
            'fk_tiket' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('assign_to_kaur');
        $this->forge->addForeignKey('fk_tiket', 'tikets', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('assign_to_kaur');
    }
}
