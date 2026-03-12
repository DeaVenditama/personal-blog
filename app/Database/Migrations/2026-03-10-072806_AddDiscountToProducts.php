<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDiscountToProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products', [
            'discount_percentage' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 0,
                'after' => 'price'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'discount_percentage');
    }
}
