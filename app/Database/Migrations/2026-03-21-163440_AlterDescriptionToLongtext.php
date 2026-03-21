<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterDescriptionToLongtext extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('portfolios', [
            'description' => [
                'type' => 'LONGTEXT',
            ],
        ]);

        $this->forge->modifyColumn('products', [
            'description' => [
                'type' => 'LONGTEXT',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('portfolios', [
            'description' => [
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->modifyColumn('products', [
            'description' => [
                'type' => 'TEXT',
            ],
        ]);
    }
}
