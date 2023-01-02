<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class PayrollComponents extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'SMALLINT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'level' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'formula' => [
                'type'      => 'VARCHAR',
                'constraint'=> '200',
                'null'      =>true
            ],
            'rp_value' => [
                'type'      => 'INT',
                'null'      =>true
            ],
            'formula_bp' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'      =>true
            ],
            'rp_value_bp' => [
                'type'       => 'INT',
                'null'      =>true
            ],
            'min_rp_value' => [
                'type'       => 'INT',
                'null'      =>true
            ],
            'limit_base_value' => [
                'type'       => 'INT',
                'null'      =>true
            ],
            'plus' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 1
            ],
            'fixed' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 1
            ],
            'need_full_absen' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 1
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('payrollcomponents');
    }

    public function down()
    {
        $this->forge->dropTable('payrollcomponents');
    }
}
