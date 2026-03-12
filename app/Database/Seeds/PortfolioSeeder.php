<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'E-Commerce Platform',
                'description' => 'A robust and highly scalable e-commerce platform built natively on CI4.',
                'image_path' => 'uploads/portfolio-ecommerce.jpg',
                'project_url' => 'https://example.com/ecommerce',
                'tools' => 'PHP, CodeIgniter, MySQL, Bootstrap 5',
                'sort_order' => 1,
                'status' => 'published',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Company Admin Dashboard System',
                'description' => 'A comprehensive data management dashboard with real-time reporting.',
                'image_path' => 'uploads/portfolio-dashboard.jpg',
                'project_url' => 'https://example.com/dashboard',
                'tools' => 'Vue.js, Laravel, Tailwind CSS',
                'sort_order' => 2,
                'status' => 'published',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('portfolios')->insertBatch($data);
    }
}
