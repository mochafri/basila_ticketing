<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCatatanPenyelesaianToTikets extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        if (! $db->fieldExists('catatan_penyelesaian', 'tikets')) {
            $fields = [
                'catatan_penyelesaian' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
            ];

            $this->forge->addColumn('tikets', $fields);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();

        if ($db->fieldExists('catatan_penyelesaian', 'tikets')) {
            $this->forge->dropColumn('tikets', ['catatan_penyelesaian']);
        }
    }
}
