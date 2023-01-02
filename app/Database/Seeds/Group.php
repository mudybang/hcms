<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Group extends Seeder
{
    public function run()
    {
        $data = [
            [
                'label'         => 'Root',
                'description'   => 'Super User'
            ],
            [
                'label'         => 'HR',
                'description'   => 'Employee Management'
            ],
            [
                'label'         => 'Recruitment',
                'description'   => 'Find Candidate & Interview'
            ],
            [
                'label'         => 'Compensation & Benefit',
                'description'   => 'Compensation, Insurance etc.'
            ],
            [
                'label'         => 'Payroll',
                'description'   => 'Setting, Generate & Payslip'
            ],
        ];
        $this->db->table('groups')->insertBatch($data);
    }
}
