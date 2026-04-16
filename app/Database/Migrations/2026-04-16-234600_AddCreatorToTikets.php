<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCreatorToTikets extends Migration
{
    public function up()
    {
        $fields = [
            'nip_creator' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'original_dokumen_name'
            ],
            'nama_creator' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'nip_creator'
            ],
        ];
        $this->forge->addColumn('tikets', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tikets', ['nip_creator', 'nama_creator']);
    }
}
