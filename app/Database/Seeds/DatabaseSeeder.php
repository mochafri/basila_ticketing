<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('RoleSeeder');
        $this->call('UserSeeder');
        $this->call('KaurSeeder');
        $this->call('StaffSeeder');
        $this->call('KategoriSeeder');
        $this->call('LayananSeeder');
        $this->call('TicketSeeder');
    }
}
