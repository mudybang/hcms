<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Employee extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'MEDIUMINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'join_date' => [
                'type'       => 'DATE',                         
            ],
            'eid_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '50'
            ],
            'branch_id' => [
                'type'       => 'SMALLINT',
                'default'    => 0
            ],
            'project_id' => [
                'type'       => 'SMALLINT',
                'default'    => 0
            ],
            'jobtitle_id' => [
                'type'       => 'SMALLINT',
                'default'    => 0
            ],
            'department_id' => [
                'type'       => 'TINYINT',
                'default'    => 0
            ],
            'grade_id' => [
                'type'       => 'TINYINT',
                'default'    => 0
            ],
            'employment_status_id' => [
                'type'       => 'TINYINT',
                'default'    => 0
            ],
            'education_id' => [
                'type'       => 'TINYINT',
                'default'    => 0
            ],
            'approved' => [
                'type'       => 'TINYINT',
                'default'    => 1
            ],
            'active' => [
                'type'       => 'TINYINT',
                'default'    => 1
            ],
            'created_at' => [
                'type'      => 'TIMESTAMP',
                'default'   => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'      => 'TIMESTAMP',
                'default'   => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('employees');
    }

    public function down()
    {
        $this->forge->dropTable('employees');
    }
}
