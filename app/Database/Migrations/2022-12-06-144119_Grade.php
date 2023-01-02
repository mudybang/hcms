<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Grade extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'TINYINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'  =>true
            ],
            'base_sallary' => [
                'type'  => 'INT',
                'null'  =>true
            ],
            'is_prorate' => [
                'type'       => 'TINYINT',
                'constraint' => "1",
                'default'    => 0
            ],
            'active' => [
                'type'       => 'TINYINT',
                'constraint' => "1",
                'default'    => 1
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('grades');
    }

    public function down()
    {
        $this->forge->dropTable('grades');
    }
}
