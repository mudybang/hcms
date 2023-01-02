<?php

namespace Modules\Employee\Models;

use CodeIgniter\Model;

class MEmployeeHistory extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'employee_histories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tag_history','number','start_date','employee_id','branch_id','department_id','project_id',
        'grade_id','jobtitle_id','employment_status_id','note','attachment','approved','signed','placement'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'tag_history' => 'required',
        'start_date' => 'required',
        'employee_id' => 'required',
        'branch_id' => 'required',
        'department_id' => 'required',
        //'project_id' => 'required',
        'grade_id' => 'required',
        'employment_status_id' => 'required',
        'jobtitle_id' => 'required',
    ];
    protected $validationMessages   = [
        'tag_history' => [
            'required'   => 'tag required.',
        ],
        'start_date' => [
            'required'   => 'start_date required.',
        ],
        'employee_id' => [
            'required'   => 'employee required.',
        ],
        'branch_id' => [
            'required'   => 'branch required.',
        ],
        'department_id' => [
            'required'   => 'department required.',
        ],
        /*'project_id' => [
            'required'   => 'project required.',
        ],*/
        'grade_id' => [
            'required'   => 'grade required.',
        ],
        'employment_status_id' => [
            'required'   => 'employment_status_id required.',
        ],
        'jobtitle_id' => [
            'required'   => 'jobtitle_id required.',
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
