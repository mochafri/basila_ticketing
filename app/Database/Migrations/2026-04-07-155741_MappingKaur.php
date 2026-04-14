<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MappingKaur extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nip_kaur' => [
                'type'=> 'VARCHAR',
                'constraint' => '255'
            ],
            'nama_kaur' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('kaurs');
    }

    public function down()
    {
        $this->forge->dropTable('kaurs');
    }
}