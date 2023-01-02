<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeeSdp extends Migration
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
            'sdp_id' => [
                'type'           => 'TINYINT',
                'unsigned'       => true,
            ],            
            'institution_name' => [
                'type'           => 'VARCHAR',
                'constraint' => '50',
                'null'       =>true
            ],
            'validation_date_end' => [
                'type'       => 'DATE',
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
        $this->forge->createTable('employee_sdps');
    }

    public function down()
    {
        $this->forge->dropTable('employee_sdps');
    }
}
