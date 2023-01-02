<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeeEducation extends Migration
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
            'year_graduate' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
                'null'       =>true
            ],
            'education_id' => [
                'type'           => 'TINYINT',
                'unsigned'       => true,
            ],
            'institution_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       =>true
            ],
            'certification_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       =>true
            ],
            'attachment' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
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
        $this->forge->createTable('employees_educations');
    }

    public function down()
    {
        $this->forge->dropTable('employees_educations');
    }
}
