<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNewsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title'       => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'      => false,
            ],
            'slug'       => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'      => false,
            ],
            'body' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            // 'data_pub' => [
            //     'type' => 'DATETIME',
            //     'null' => true,
            //     'default' => CURRENT_TIMESTAMP
            // ],
            'data_pub datetime default current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('slug');
        $this->forge->createTable('news');
    }

    public function down()
    {
        $this->forge->dropTable('news');
    }
}