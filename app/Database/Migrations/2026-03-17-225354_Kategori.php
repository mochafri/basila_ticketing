<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'kategori_layanan'  => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
                'unique'            => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('kategoris');
    }

    public function down()
    {
        $this->forge->dropTable('kategoris');
    }
}
