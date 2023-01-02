<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Perm extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'group_id' => [
                'type'           => 'TINYINT',
                'unsigned'       => true,
            ],
            'module_id' => [
                'type'           => 'TINYINT',
                'unsigned'       => true,
            ],
            'c' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0
            ],
            'r' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0
            ],
            'u' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0
            ],
            'd' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0
            ],
            'r_all' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0
            ],
            'a' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0
            ],
            'excel' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0
            ],
        ]);
        $this->forge->addKey('group_id', true);
        $this->forge->addKey('module_id', true);
        $this->forge->createTable('perms');
    }

    public function down()
    {
        $this->forge->dropTable('perms');
    }
}
