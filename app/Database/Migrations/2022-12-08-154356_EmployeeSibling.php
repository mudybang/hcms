<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeeSibling extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'MEDIUMINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'employee_id' => [
                'type'           => 'MEDIUMINT',
                'unsigned'       => true,                 
            ],
            'sibling' => [
                'type'       => 'VARCHAR',
                'constraint' => '10'
            ],
            'ektp_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '16'
            ],
            'fullname' => [
                'type'       => 'VARCHAR',
                'constraint' => '60'
            ],
            'gender' => [
                'type'       => 'VARCHAR',
                'constraint' => '6'
            ],
            'place_birth' => [
                'type'       => 'VARCHAR',
                'constraint' => '20'
            ],
            'date_birth' => [
                'type'       => 'DATE',
            ],
            'education_id' => [
                'type'       => 'TINYINT',
                'unsigned'   => true,
                'null'       => true
            ],
            'job' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true
            ],
            'marital_status' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
                'null'       => true
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
        $this->forge->createTable('employees_sibling');
    }

    public function down()
    {
        $this->forge->dropTable('employees_sibling');
    }
}
