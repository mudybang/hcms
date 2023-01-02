<?php

namespace Modules\Insurance\Models;

use CodeIgniter\Model;

class MInsurance extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'employee_insurances';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['employee_id','insurance_name','card_number','register_date','expired_date','given_date','receipn'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'employee_id' => 'required',
        'insurance_name' => 'required',
        'card_number' => 'required',
    ];
    protected $validationMessages   = [
        'employee_id' => [
            'required'   => 'Employee required.',
        ],
        'insurance_name' => [
            'required'   => 'Insurance required.',
        ],
        'card_number' => [
            'required'   => 'Card_number required.',
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
