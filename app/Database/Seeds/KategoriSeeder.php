<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['kategori_layanan' => 'Jaringan dan Infrastruktur'],
            ['kategori_layanan' => 'Sistem Informasi dan Aplikasi'],
            ['kategori_layanan' => 'Perangkat Keras (Hardware)'],
            ['kategori_layanan' => 'Akun dan Akses (SSO)'],
            ['kategori_layanan' => 'Layanan Email dan Hosting']
        ];
        
        $this->db->table('kategoris')->insertBatch($data);
    }
}
