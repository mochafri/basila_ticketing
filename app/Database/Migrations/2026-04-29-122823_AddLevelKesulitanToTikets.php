<?php
/**
 * Migration to add level_kesulitan to tikets table
 */
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLevelKesulitanToTikets extends Migration
{
    public function up()
    {
        $fields = [
            'level_kesulitan' => [
                'type'       => 'ENUM',
                'constraint' => ['mudah', 'sedang', 'sulit'],
                'null'       => true,
                'after'      => 'tiket_status'
            ],
        ];
        $this->forge->addColumn('tikets', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tikets', 'level_kesulitan');
    }
}
