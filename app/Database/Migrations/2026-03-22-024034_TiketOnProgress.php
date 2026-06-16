<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TiketOnProgress extends Migration
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
            'nip_receive_task' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'received_by' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'task_instruction' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'task_status' => [
                'type' => 'ENUM',
                'constraint' => ['Sedang Pengerjaan', 'Menunggu Approve', 'Revisi', 'Selesai'],
                'default' => 'Sedang Pengerjaan'
            ],
            'taks_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'is_kaur_accepted' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'original_task_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'catatan_revisi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'catatan_laporan_penyelesaian' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'fk_assign_to_kaur' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ]   
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tiket_on_progress');
        $this->forge->addForeignKey('fk_assign_to_kaur', 'assign_to_kaur', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('tiket_on_progress');
    }
}
