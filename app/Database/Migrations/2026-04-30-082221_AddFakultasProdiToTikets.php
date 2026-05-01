<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFakultasProdiToTikets extends Migration
{
    public function up()
    {
        $fields = [
            'fakultas' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'nama_creator'
            ],
            'prodi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'fakultas'
            ],
        ];
        $this->forge->addColumn('tikets', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tikets', ['fakultas', 'prodi']);
    }
}
