<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Provice extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iso' => [
                'type'          => 'VARCHAR',
                'constraint'    => '2'
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '50'
            ],
            'capital' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'active' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
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
        $this->forge->addKey('iso', true);
        $this->forge->createTable('provinces');
    }

    public function down()
    {
        $this->forge->dropTable('provinces');
    }
}
