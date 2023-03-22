<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToUserMigration extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'role_code' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'after' => 'password',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'role_code');
    }
}
