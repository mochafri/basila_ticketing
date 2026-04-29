<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->where('id >', 0)->delete();
        $data = [
            [
                'username' => 'admin',
                'nip' => '000000',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'kabag',
                'nip' => '111111',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'kaur1',
                'nip' => '1987654321', // NIP KAUR 1
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'kaur2',
                'nip' => '1987654322', // NIP KAUR 2
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'staffA1',
                'nip' => '2001001', // STAFF A1
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'staffA2',
                'nip' => '2001002', // STAFF A2
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'staffB1',
                'nip' => '2002001', // STAFF B1
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'staffB2',
                'nip' => '2002002', // STAFF B2
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('users')->insertBatch($data);

        // MAPPING ROLES (Agar bisa login sesuai alur baru)
        $mapping = [
            [
                'user_nip' => '000000', // admin
                'user_fullname' => 'Administrator',
                'role_id' => 38054 // SUPERADMIN
            ],
            [
                'user_nip' => '111111', // kabag
                'user_fullname' => 'Kepala Bagian',
                'role_id' => 38055 // BAA
            ],
            [
                'user_nip' => '1987654321', // kaur1
                'user_fullname' => 'Kaur Akademik 1',
                'role_id' => 948523 // KEPALA URUSAN ADMINISTRASI AKADEMIK
            ],
            [
                'user_nip' => '1987654322', // kaur2
                'user_fullname' => 'Kaur Akademik 2',
                'role_id' => 38057 // ADMIN DATA MAHASISWA FAKULTAS
            ],
            [
                'user_nip' => '2001001', // staffA1
                'user_fullname' => 'Staff A1',
                'role_id' => 38056 // PEGAWAI
            ],
            [
                'user_nip' => '2001002', // staffA2
                'user_fullname' => 'Staff A2',
                'role_id' => 38056 // PEGAWAI
            ],
            [
                'user_nip' => '2002001', // staffB1
                'user_fullname' => 'Staff B1',
                'role_id' => 38056 // PEGAWAI
            ],
            [
                'user_nip' => '2002002', // staffB2
                'user_fullname' => 'Staff B2',
                'role_id' => 38056 // PEGAWAI
            ]
        ];

        $this->db->table('user_roles')->where('id >', 0)->delete();
        $this->db->table('user_roles')->insertBatch($mapping);
    }
}
