<?php

namespace Modules\Loan\Models;

use CodeIgniter\Model;

class MLoan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'loans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['employee_id','title','note','receive_date','rp_value','installment','installment_rest','approved','receipn'];

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
        'rp_value'      => 'required',
    ];
    protected $validationMessages   = [
        'employee_id' => [
            'required'   => 'Name required.',
        ],
        'title' => [
            'required'   => 'Title required.',
        ],
        'rp_value' => [
            'required'   => 'Value required.',
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
