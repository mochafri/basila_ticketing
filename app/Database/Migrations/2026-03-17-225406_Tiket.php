<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tiket extends Migration
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
            'id_kategori' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => false
            ],
            'id_layanan' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true
            ],
            'judul_permohonan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'deskripsi_permohonan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'dokumen_lampiran' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'original_dokumen_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'is_escalated' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'approve_by' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'tiket_status' => [
                'type' => 'ENUM',
                'constraint' => ['Waiting', 'Open', 'In Progress', 'Closed', 'Rejected'],
                'default' => 'Waiting'
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tikets');
        $this->forge->addForeignKey('id_layanan', 'layanans', 'id', 'RESTRICT', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('tikets');
    }
}
