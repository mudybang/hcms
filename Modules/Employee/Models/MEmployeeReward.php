<?php

namespace Modules\Employee\Models;

use CodeIgniter\Model;

class MEmployeeReward extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'employee_rewards';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['employee_id','title','description','given_date','given_by','attachment'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'employee_id'   => 'required',
        'title'         => 'required',
        'given_date'    => 'required',
    ];
    protected $validationMessages   = [
        'employee_id' => [
            'required'   => 'Name required.',
        ],
        'title' => [
            'required'   => 'Title required.',
        ],
        'given_date' => [
            'required'   => 'Date required.',
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
