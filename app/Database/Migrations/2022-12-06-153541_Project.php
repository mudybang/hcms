<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Project extends Migration
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
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'  =>true
            ],
            'branch_id' => [
                'type'     => 'TINYINT',
            ],
            'address' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'      =>true
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'      =>true
            ],
            'province' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'      =>true
            ],
            'day_cut_off' => [
                'type'      => 'TINYINT',
                'default'   =>1
            ],
            'latitude' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'      =>true
            ],
            'longitude' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'      =>true
            ],
            'limit_distances' => [
                'type'      => 'SMALLINT',
                'default'   =>100
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
        $this->forge->addPrimaryKey('id', true);
        $this->forge->addUniqueKey('code', true);
        $this->forge->createTable('projects');
    }

    public function down()
    {
        $this->forge->dropTable('projects');
    }
}
