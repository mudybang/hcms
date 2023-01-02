<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeeWarning extends Migration
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
                'type'          => 'MEDIUMINT',
                'unsigned'      => true,
            ],
            'number'=> [
                'type'          => 'TINYINT',
                'constraint'    => '1',
                'unsigned'      => true,
                'default'       => '1'
            ],
            'title' => [
                'type'          => 'VARCHAR',
                'constraint'    => '50',
            ],
            'description' => [
                'type'          => 'VARCHAR',
                'constraint'    => '100',
                'null'          =>true
            ],       
            'given_date' => [
                'type'       => 'DATE',
            ],
            'given_by' => [
                'type'          => 'VARCHAR',
                'constraint'    => '20',
            ],
            'attachment' => [
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
        $this->forge->createTable('employee_warnings');
    }

    public function down()
    {
        $this->forge->dropTable('employee_warnings');
    }
}
