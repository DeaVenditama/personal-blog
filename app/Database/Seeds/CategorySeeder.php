<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
            ],
            [
                'name' => 'Tutorials',
                'slug' => 'tutorials',
            ],
            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
            ]
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}
