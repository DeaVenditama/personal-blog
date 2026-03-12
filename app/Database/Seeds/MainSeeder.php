<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        //$this->call('UserSeeder');
        $this->call('CategorySeeder');
        $this->call('PostSeeder');
        $this->call('MediaSeeder');
        $this->call('PortfolioSeeder');
        $this->call('ProductSeeder');
        $this->call('MessageSeeder');
    }
}
