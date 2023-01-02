<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeeInsurance extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'TINYINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'employee_id' => [
                'type'       => 'MEDIUMINT',
                'unsigned'       => true,
            ],
            'sibling' => [
                'type'      => 'VARCHAR',
                'unsigned'  => true,
            ],
            'card_number' => [
                'type'      => 'VARCHAR',
                'constraint'=> '20',
            ],
            'register_date' => [
                'type'      => 'DATE',
            ],
            'expired_date'  => [
                'type'      => 'DATE',
            ],
            'receipn' => [
                'type'      => 'VARCHAR',
                'constraint'=> '100',
                'null'      =>true
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['employee_id', 'sibling']);
        $this->forge->createTable('employee_insurances');
    }

    public function down()
    {
        $this->forge->dropTable('employee_insurances');
    }
}
