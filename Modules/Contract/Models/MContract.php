<?php

namespace Modules\Contract\Models;

use CodeIgniter\Model;

class MContract extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'employee_contracts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['employee_id','number','ordering','start_date','end_date',
        'department_id','grade_id','jobtitle_id','employment_status_id','branch_id','project_id',
        'signed','placement','attachment'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'employee_id' => 'required',
        'start_date' => 'required',
    ];
    protected $validationMessages   = [
        'name' => [
            'required'   => 'Eployee required.',
        ],
        'start_date' => [
            'required'   => 'Date required.',
        ],
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
