<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePortfoliosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'image_path' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'project_url' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'tools' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'published'],
                'default' => 'draft',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('portfolios');
    }

    public function down()
    {
        $this->forge->dropTable('portfolios');
    }
}
