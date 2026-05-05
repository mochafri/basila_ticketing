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
        $this->forge->addColumn('tiket_on_progress', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tiket_on_progress', 'is_downloadable');
    }
}
