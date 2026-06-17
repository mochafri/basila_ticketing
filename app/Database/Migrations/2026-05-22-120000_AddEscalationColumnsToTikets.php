<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEscalationColumnsToTikets extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // Add columns only if they don't already exist
        if (! $db->fieldExists('is_escalated', 'tikets')
            || ! $db->fieldExists('notes_request_escalated', 'tikets')
            || ! $db->fieldExists('notes_after_escalated', 'tikets')) {

            $fields = [];

            if (! $db->fieldExists('is_escalated', 'tikets')) {
                $fields['is_escalated'] = [
                    'type'    => 'BOOLEAN',
                    'default' => false,
                ];
            }

            if (! $db->fieldExists('notes_request_escalated', 'tikets')) {
                $fields['notes_request_escalated'] = [
                    'type' => 'TEXT',
                    'null' => true,
                ];
            }

            if (! $db->fieldExists('notes_after_escalated', 'tikets')) {
                $fields['notes_after_escalated'] = [
                    'type' => 'TEXT',
                    'null' => true,
                ];
            }

            if (! empty($fields)) {
                $this->forge->addColumn('tikets', $fields);
            }
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();

        $drop = [];
        if ($db->fieldExists('is_escalated', 'tikets')) {
            $drop[] = 'is_escalated';
        }
        if ($db->fieldExists('notes_request_escalated', 'tikets')) {
            $drop[] = 'notes_request_escalated';
        }
        if ($db->fieldExists('notes_after_escalated', 'tikets')) {
            $drop[] = 'notes_after_escalated';
        }

        if (! empty($drop)) {
            $this->forge->dropColumn('tikets', $drop);
        }
    }
}
