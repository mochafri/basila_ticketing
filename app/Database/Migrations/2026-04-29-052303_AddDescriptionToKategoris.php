<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDescriptionToKategoris extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kategoris', [
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'kategori_layanan'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kategoris', 'deskripsi');
    }
}
