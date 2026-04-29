<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsDownloadableToAssignToStaff extends Migration
{
    public function up()
    {
        $fields = [
            'is_downloadable' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
                'after'      => 'taks_dokumen'
            ],
        ];
        $this->forge->addColumn('assign_to_staff', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('assign_to_staff', 'is_downloadable');
    }
}
