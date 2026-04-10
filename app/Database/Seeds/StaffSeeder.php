<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run()
    {
        $staffs = [
            [
                'nip_staff' => '2001001',
                'nama_staff' => 'Staff A1',
                'fk_kaur' => 1, 
            ],
            [
                'nip_staff' => '2001002',
                'nama_staff' => 'Staff A2',
                'fk_kaur' => 1,
            ],
            [
                'nip_staff' => '2002001',
                'nama_staff' => 'Staff B1',
                'fk_kaur' => 2, 
            ],
            [
                'nip_staff' => '2002002',
                'nama_staff' => 'Staff B2',
                'fk_kaur' => 2,
            ],
        ];

        foreach ($staffs as $staff) {
            $this->db->table('staffs')->insert($staff);
        }
    }
}
