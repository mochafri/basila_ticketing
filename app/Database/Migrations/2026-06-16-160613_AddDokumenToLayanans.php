<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDokumenToLayanans extends Migration
{
    public function up()
    {
        $fields = [
            'kebutuhan_dokumen' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'template_dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ];
        $this->forge->addColumn('layanans', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('layanans', 'kebutuhan_dokumen');
        $this->forge->dropColumn('layanans', 'template_dokumen');
    }
}
