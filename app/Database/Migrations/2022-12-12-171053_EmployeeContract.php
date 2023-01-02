<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeeContract extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'MEDIUMINT',
                'unsigned'       => true,
                'auto_increment' => true              
            ],
            'employee_id'    => [
                'type'       => 'MEDIUMINT',
                'unsigned'       => true,
            ],
            'number' => [
                'type'       => 'VARCHAR',
                'constraint' => '10'
            ],
            'ordering' => [
                'type'       => 'TINYINT',
                'default'    => 1
            ],
            'start_date' => [
                'type'       => 'DATE',
            ],
            'end_date' => [
                'type'       => 'DATE',
            ],
            'department_id' => [
                'type'      => 'TINYINT',
                'default'   => 0
            ],
            'grade_id' => [
                'type'      => 'TINYINT',
                'default'   => 0
            ],
            'jobtitle_id' => [
                'type'      => 'TINYINT',
                'default'   => 0
            ],
            'employment_status_id' => [
                'type'      => 'TINYINT',
                'default'   => 0
            ],
            'branch_id' => [
                'type'      => 'TINYINT',
                'default'   => 0
            ],
            'project_id' => [
                'type'      => 'TINYINT',
                'default'   => 0
            ],
            'attachment' => [
                'type'       => 'VARCHAR',
                'constraint' => '50'
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
        $this->forge->addUniqueKey('employee_id, ordering', true);
        $this->forge->createTable('employee_contracts');
    }

    public function down()
    {
        $this->forge->dropTable('employee_contracts');
    }
}
