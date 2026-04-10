<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Kategori 1: Jaringan dan Infrastruktur
            ['per_kategori_layanan' => 'Instalasi Jaringan Internet Baru', 'fk_kategori' => 1],
            ['per_kategori_layanan' => 'Laporan Gangguan Koneksi WiFi / LAN', 'fk_kategori' => 1],
            
            // Kategori 2: Sistem Informasi dan Aplikasi
            ['per_kategori_layanan' => 'Perbaikan Bug pada Sistem Akademik', 'fk_kategori' => 2],
            ['per_kategori_layanan' => 'Permintaan Penambahan Fitur Sistem', 'fk_kategori' => 2],
            
            // Kategori 3: Perangkat Keras (Hardware)
            ['per_kategori_layanan' => 'Peminjaman Perangkat Komputer / Proyektor', 'fk_kategori' => 3],
            ['per_kategori_layanan' => 'Perbaikan Komputer / Printer Rusak', 'fk_kategori' => 3],
            
            // Kategori 4: Akun dan Akses (SSO)
            ['per_kategori_layanan' => 'Reset Password Akun SSO', 'fk_kategori' => 4],
            ['per_kategori_layanan' => 'Pembuatan Akun Pegawai Baru', 'fk_kategori' => 4],
            
            // Kategori 5: Layanan Email dan Hosting
            ['per_kategori_layanan' => 'Pembuatan Email Institusi Baru', 'fk_kategori' => 5],
            ['per_kategori_layanan' => 'Permintaan Akses Hosting Aplikasi Divisi', 'fk_kategori' => 5]
        ];
        
        $this->db->table('layanans')->insertBatch($data);
    }
}
