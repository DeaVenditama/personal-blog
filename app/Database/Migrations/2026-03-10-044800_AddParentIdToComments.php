<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddParentIdToComments extends Migration
{
    public function up()
    {
        $fields = [
            'parent_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'is_admin' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
        ];

        $this->forge->addColumn('comments', $fields);

        // Note: Adding a foreign key on an existing table using addColumn might require execute direct query
        // but $this->forge->addForeignKey isn't supported alongside addColumn directly on some drivers
        // So we will execute custom SQL for the foreign key.
        $this->db->query('ALTER TABLE comments ADD CONSTRAINT fk_parent_id FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE comments DROP FOREIGN KEY fk_parent_id');
        $this->forge->dropColumn('comments', 'parent_id');
        $this->forge->dropColumn('comments', 'is_admin');
    }
}
