<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeeBpjsTK extends Migration
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
            'card_number' => [
                'type'      => 'VARCHAR',
                'constraint'=> '20',
            ],
            'register_date' => [
                'type'      => 'DATE',
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
        $this->forge->createTable('employee_bpjstk');
    }

    public function down()
    {
        $this->forge->dropTable('employee_bpjstk');
    }
}
