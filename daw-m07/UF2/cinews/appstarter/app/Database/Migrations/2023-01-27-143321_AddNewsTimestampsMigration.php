<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNewsTimestampsMigration extends Migration
{
    public function up()
    {
        $fields = [
            'created_at'          => [
                'type'           => 'DATETIME',
            ],
            'updated_at'          => [
                'type'           => 'DATETIME',
            ],
            'deleted_at'          => [
                'type'           => 'DATETIME',
            ],

        ];
        $this->forge->addColumn('news', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('news', ['created_at','deleted_at','updated_at']);
    }
}