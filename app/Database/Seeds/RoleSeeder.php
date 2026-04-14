<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 38054, 'role_name' => 'SUPERADMIN'],
            ['id' => 38055, 'role_name' => 'BAA'],
            ['id' => 38056, 'role_name' => 'PEGAWAI'],
            ['id' => 38057, 'role_name' => 'ADMIN DATA MAHASISWA FAKULTAS'],
            ['id' => 38059, 'role_name' => 'ADMIN LAC'],
            ['id' => 38061, 'role_name' => 'BK TEL-U'],
            ['id' => 38062, 'role_name' => 'KELOMPOK KEAHLIAN'],
            ['id' => 38063, 'role_name' => 'ADMIN BK'],
            ['id' => 38064, 'role_name' => 'DEVTEAM'],
            ['id' => 987229, 'role_name' => 'STAFF URUSAN MANAJEMEN MUTU TEKNOLOGI INFORMASI'],
            ['id' => 295404, 'role_name' => 'STAFF URUSAN PENGEMBANGAN STANDAR, METODE, DAN TEKNOLOGI PEMBELAJARAN'],
            ['id' => 987429, 'role_name' => 'EXTERNAL AUDITOR'],
            ['id' => 948523, 'role_name' => 'KEPALA URUSAN ADMINISTRASI AKADEMIK'],
            ['id' => 1173292, 'role_name' => 'ADMIN AKADEMIK'],
            ['id' => 1135890, 'role_name' => 'KEPALA URUSAN ADMINISTRASI AKADEMIK'],
            ['id' => 1141824, 'role_name' => 'ADMIN LAAK'],
            ['id' => 824030, 'role_name' => 'DOSEN']
        ];

        $this->db->table('roles')->ignore(true)->insertBatch($data);
    }
}
