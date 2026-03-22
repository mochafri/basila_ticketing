<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Layanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
                'null'              => false
            ],
            'per_kategori_layanan'  => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false
            ],
            'fk_kategori'           => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true
            ]
        ]);

        $this->forge->addKey('id',true);
        $this->forge->createTable('layanans');
        $this->forge->addForeignKey('fk_kategori', 'kategoris', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('layanans');
    }
}
