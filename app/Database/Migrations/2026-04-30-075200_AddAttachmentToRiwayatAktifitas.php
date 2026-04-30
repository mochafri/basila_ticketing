<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAttachmentToRiwayatAktifitas extends Migration
{
    public function up()
    {
        $fields = [
            'attachment' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'message'
            ],
            'original_attachment_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'attachment'
            ],
        ];
        $this->forge->addColumn('riwayat_aktifitas', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('riwayat_aktifitas', 'attachment');
        $this->forge->dropColumn('riwayat_aktifitas', 'original_attachment_name');
    }
}
