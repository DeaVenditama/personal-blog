<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'filename' => 'sample-project-image.jpg',
                'file_path' => 'uploads/sample-project-image.jpg',
                'file_type' => 'image/jpeg',
                'file_size' => 512.45, // KB
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 1,
                'filename' => 'hero-banner.png',
                'file_path' => 'uploads/hero-banner.png',
                'file_type' => 'image/png',
                'file_size' => 1024.12, // KB
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('media')->insertBatch($data);
    }
}
