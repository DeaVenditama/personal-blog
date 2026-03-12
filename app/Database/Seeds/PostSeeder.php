<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'Getting Started with CodeIgniter 4',
                'slug' => 'getting-started-with-codeigniter-4',
                'content' => '<p>This is a sample post exploring the core concepts of CodeIgniter 4.</p>',
                'status' => 'published',
                'read_count' => 150,
                'published_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'title' => 'Advanced PHP Design Patterns',
                'slug' => 'advanced-php-design-patterns',
                'content' => '<p>Let\'s dive into the fascinating world of software design patterns in PHP.</p>',
                'status' => 'published',
                'read_count' => 45,
                'published_at' => date('Y-m-d H:i:s', strtotime('-1 days')),
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('posts')->insertBatch($data);
    }
}
