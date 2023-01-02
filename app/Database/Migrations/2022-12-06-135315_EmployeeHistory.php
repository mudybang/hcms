<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeeHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'MEDIUMINT',
                'unsigned'       => true,
                'auto_increment' => true              
            ],
            'tag_history' => [
                'type'       => 'VARCHAR',
                'constraint' => '10'
            ],
            'start_date' => [
                'type'       => 'DATE',
            ],
            'employee_id' => [
                'type'       => 'MEDIUMINT',
                'unsigned'       => true,
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
            'aprroved' => [
                'type'      => 'TINYINT',
                'constraint'=> '1',
                'default'   => '1'
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
        $this->forge->addUniqueKey('employee_id, start_date', true);
        $this->forge->createTable('employee_histories');
    }

    public function down()
    {
        $this->forge->dropTable('employee_histories');
    }
}
