<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Option extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'option' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ]
        ]);
        $this->forge->createTable('options');
    }

    public function down()
    {
        $this->forge->dropTable('options');
    }
}
