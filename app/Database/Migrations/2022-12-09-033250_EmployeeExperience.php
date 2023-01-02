<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeeExperience extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'MEDIUMINT',
                'unsigned'       => true,
                'auto_increment' => true              
            ],
            'employee_id' => [
                'type'           => 'MEDIUMINT',
                'unsigned'       => true,
            ],
            'company_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'company_desc' => [
                'type'           => 'VARCHAR',
                'constraint' => '100',
                'null'       =>true
            ],
            'jobtitle' => [
                'type'           => 'VARCHAR',
                'constraint' => '50',
                'null'       =>true
            ],
            'job_desc' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       =>true
            ],
            'year_start' => [
                'type'       => 'SMALLINT',
                'null'       =>true
            ],
            'year_end' => [
                'type'       => 'SMALLINT',
                'null'       =>true
            ],
            'sallary' => [
                'type'       => 'INT',
                'null'       =>true
            ],
            'reason_leave' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       =>true
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
        $this->forge->createTable('employee_experiences');
    }

    public function down()
    {
        $this->forge->dropTable('employee_experiences');
    }
}
