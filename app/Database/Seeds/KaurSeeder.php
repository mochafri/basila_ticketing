<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KaurSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nip_kaur' => '1987654321', // NIP atau kode internal
                'nama_kaur' => 'Pak Bagas',
            ],
            [
                'nip_kaur' => '1987654322',
                'nama_kaur' => 'Buk Ida',
            ],
        ];

        foreach ($data as $kaur) {
            $this->db->table('kaurs')->insert($kaur);
        }
    }
}