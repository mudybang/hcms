<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeeBio extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'employee_id' => [
                'type'           => 'MEDIUMINT',
                'unsigned'       => true                
            ],
            'ektp_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '20'
            ],
            'fullname' => [
                'type'       => 'VARCHAR',
                'constraint' => '50'
            ],
            'gender' => [
                'type'       => 'VARCHAR',
                'constraint' => '6'
            ],
            'place_birth' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'date_birth' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'religion' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'address' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'       => true,
            ],
            'district' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'village' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true
            ],
            'province' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'postcode' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true
            ],
            'marital_status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true
            ],
            'img_profile' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'default'    => 'no_picture'
            ],
            'attachment_cv' => [
                'type'          => 'VARCHAR',
                'constraint'    => '10',
                'null'          => true
            ],
            'attachment_ektp'    =>[
                'type'       => 'TINYINT',
                'null'       => true
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
        $this->forge->addPrimaryKey('employee_id', true);
        $this->forge->addUniqueKey('ektp_number', true);
        $this->forge->createTable('employee_bio');
    }

    public function down()
    {
        $this->forge->dropTable('employee_bio');
    }
}
