<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeeSallary extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'employee_id' => [
                'type'           => 'MEDIUMINT',
                'unsigned'       => true,
            ],
            'base_sallary' => [
                'type'       => 'INT',
                'default'    => 0
            ],
            'prorate' => [
                'type'       => 'TINYINT',
                'constraint' => '1'
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
        $this->forge->addKey('employee_id', true);
        $this->forge->createTable('employee_sallary');
    }

    public function down()
    {
        $this->forge->dropTable('employee_sallary');
    }
}
