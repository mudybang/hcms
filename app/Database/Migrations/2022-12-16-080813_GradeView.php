<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class GradeView extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'group_id' => [
                'type'           => 'TINYINT',
                'unsigned'       => true,
            ],
            'grade_id' => [
                'type'       => 'TINYINT',
                'unsigned'       => true,
            ],
            'r' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0
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
        $this->forge->addKey('grade_id', true);
        $this->forge->createTable('grade_views');
    }

    public function down()
    {
        $this->forge->dropTable('grade_views');
    }
}
