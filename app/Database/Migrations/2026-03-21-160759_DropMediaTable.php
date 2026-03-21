<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropMediaTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('media', true);
    }

    public function down()
    {
        // Recreate the table if needed, though usually not strictly necessary for deletion scripts
    }
}
