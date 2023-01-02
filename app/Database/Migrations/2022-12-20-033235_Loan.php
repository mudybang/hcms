<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Loan extends Migration
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
                'type'       => 'MEDIUMINT',
                'unsigned'       => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'note' => [
                'type'       => 'VARCHAR',
                'constraint' => '200'
            ],
            'approved' => [
                'type'       => 'TINYINT',
                'constraint' => '1'
            ],
            'receive_date' => [
                'type'       => 'DATE',
            ],
            'rp_value' => [
                'type'       => 'INT',
            ],
            'installment' => [
                'type'       => 'TINYINT',
            ],
            'installment_rest' => [
                'type'       => 'TINYINT',
            ],
            'receipn' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
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
        $this->forge->createTable('loans');
    }

    public function down()
    {
        $this->forge->dropTable('loans');
    }
}
