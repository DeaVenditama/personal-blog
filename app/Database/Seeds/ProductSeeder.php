<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'slug' => 'premium-lms-script',
                'title' => 'Premium LMS Source Code',
                'description' => 'A complete Learning Management System script. Start your online academy today.',
                'features' => json_encode(["User Management", "Course builder", "Payment Gateway Integration", "Quiz Engine"]),
                'price' => 500000,
                'discount_percentage' => 20,
                'demo_url' => 'https://demo.example.com/lms',
                'thumbnail' => 'product-lms.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'pos-system-source-code',
                'title' => 'Retail POS System (Point of Sale)',
                'description' => 'A Point of Sale system suitable for small to medium retail stores. Highly adaptable.',
                'features' => json_encode(["Inventory Tracking", "Sales Reporting", "Barcode Scanner Support", "Receipt Printing"]),
                'price' => 250000,
                'discount_percentage' => 0,
                'demo_url' => 'https://demo.example.com/pos',
                'thumbnail' => 'product-pos.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('products')->insertBatch($data);
    }
}
