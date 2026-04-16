<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RiwayatAktifitas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'activity_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'message' => [
                'type' => 'TEXT'
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'fk_tiket' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('fk_tiket', 'tikets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('riwayat_aktifitas');
    }

    public function down()
    {
        $this->forge->dropTable('riwayat_aktifitas');
    }
}
