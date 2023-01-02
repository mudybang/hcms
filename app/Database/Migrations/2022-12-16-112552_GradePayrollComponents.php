<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class GradePayrollComponents extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'grade_id' => [
                'type'       => 'TINYINT',
                'unsigned'       => true,
            ],
            'component_id' => [
                'type'           => 'TINYINT',
                'unsigned'       => true,
            ],
            'active' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
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
        $this->forge->addKey('group_id', true);
        $this->forge->addKey('component_id', true);
        $this->forge->createTable('grade_payrollcomponents');
    }

    public function down()
    {
        $this->forge->dropTable('grade_payrollcomponents');
    }
}
