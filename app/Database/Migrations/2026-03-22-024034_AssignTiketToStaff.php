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
            'approve_by_kabag' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'assign_task_to_staff' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'task_status' => [
                'type' => 'ENUM',
                'constraint' => ['In Progress', 'Revisi', 'Finish'],
                'default' => 'In Progress'
            ],
            'taks_dokumen' => [
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
