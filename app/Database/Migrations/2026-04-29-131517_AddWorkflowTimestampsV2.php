<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWorkflowTimestampsV2 extends Migration
{
    public function up()
    {
        // Add completed_at to tikets
        if (!$this->db->fieldExists('completed_at', 'tikets')) {
            $this->forge->addColumn('tikets', [
                'completed_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'created_at'
                ],
            ]);
        }

        // Add started_at and completed_at to assign_to_kaur
        $kaurFields = [];
        if (!$this->db->fieldExists('started_at', 'assign_to_kaur')) {
            $kaurFields['started_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'flag'
            ];
        }
        if (!$this->db->fieldExists('completed_at', 'assign_to_kaur')) {
            $kaurFields['completed_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'started_at'
            ];
        }
        if (!empty($kaurFields)) {
            $this->forge->addColumn('assign_to_kaur', $kaurFields);
        }

        // Add started_at and completed_at to assign_to_staff
        $staffFields = [];
        if (!$this->db->fieldExists('started_at', 'tiket_on_progress')) {
            $staffFields['started_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'task_status'
            ];
        }
        if (!$this->db->fieldExists('completed_at', 'tiket_on_progress')) {
            $staffFields['completed_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'started_at'
            ];
        }
        if (!empty($staffFields)) {
            $this->forge->addColumn('tiket_on_progress', $staffFields);
        }
    }

    public function down()
    {
        //
    }
}
