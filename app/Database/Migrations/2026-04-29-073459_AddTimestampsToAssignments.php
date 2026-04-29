<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsToAssignments extends Migration
{
    public function up()
    {
        // Add completed_at to tikets
        $this->forge->addColumn('tikets', [
            'completed_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at'
            ],
        ]);

        // Add started_at and completed_at to assign_to_kaur
        $this->forge->addColumn('assign_to_kaur', [
            'started_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'flag'
            ],
            'completed_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'started_at'
            ],
        ]);

        // Add started_at and completed_at to assign_to_staff
        $this->forge->addColumn('assign_to_staff', [
            'started_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'task_status'
            ],
            'completed_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'started_at'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tikets', 'completed_at');
        $this->forge->dropColumn('assign_to_kaur', ['started_at', 'completed_at']);
        $this->forge->dropColumn('assign_to_staff', ['started_at', 'completed_at']);
    }
}
