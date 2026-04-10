<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AssignTiketToStaff extends Migration
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
            'nip_staff' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'assign_task_to_staff' => [
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
                'null' => false
            ],
            'catatan_revisi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'catatan_laporan_penyelesaian' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'fk_assign_tiket' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('assign_to_staff');
        $this->forge->addForeignKey('fk_assign_tiket', 'assign_tiket', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('assign_to_staff');
    }
}
