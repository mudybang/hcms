<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Menu extends Seeder
{
    public function run()
    {
        $data = [
            [
                'label'     => 'System',
                'icon'      => 'cog'
            ],
            [
                'label'     => 'Admin',
                'icon'      => 'user-cog'
            ],
            [
                'label'     => 'Recruitment',
                'icon'      => 'id-card-alt'
            ],
            [
                'label'     => 'Employee',
                'icon'      => 'user_friends'
            ],
            [
                'label'     => 'Attendant',
                'icon'      => 'user_clock'
            ],
            [
                'label'     => 'Payroll Setting',
                'icon'      => 'cog'
            ],
            [
                'label'     => 'Payslip',
                'icon'      => 'file-invoice-dollar'
            ],
            [
                'label'     => 'Tools',
                'icon'      => 'tools'
            ],
            [
                'label'     => 'General Setting',
                'icon'      => 'sliders-h'
            ],
            [
                'label'     => 'Project Modules',
                'icon'      => 'project-diagram'
            ]
        ];
        $this->db->table('menus')->insertBatch($data);
    }
}
