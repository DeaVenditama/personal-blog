<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'message' => 'Hello! I am very interested in the premium LMS script. Do you offer discounts?',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour'))
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'message' => 'Hi Dea, could we collaborate on a new freelance project? Let me know!',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('messages')->insertBatch($data);
    }
}
