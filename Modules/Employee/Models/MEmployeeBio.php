<?php

namespace Modules\Employee\Models;

use CodeIgniter\Model;

class MEmployeeBio extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'employee_bio';
    protected $primaryKey       = 'employee_id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['employee_id','ektp_number','fullname','gender','place_birth','date_birth','religion','address','district',
        'village','city','province','postcode','marital_status','kk_number','email','phone','img_profile','attachment_cv','attachment_ektp','attachment_kk','active'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'employee_id' => 'required',
        'ektp_number' => 'required|is_unique[employee_bio.ektp_number]',
        'fullname' => 'required',
        'gender' => 'required',
        'place_birth' => 'required',
        'date_birth' => 'required',
        'address' => 'required',
        'district' => 'required',
        'village' => 'required',
        'city' => 'required',
        'province' => 'required',
        'marital_status' => 'required',
        'email' => 'required',
        'phone' => 'required',
    ];
    protected $validationMessages   = [
        'employee_id' => [
            'required'   => 'employee_id required.',
        ],
        'ektp_number' => [
            'required'   => 'ektp_number required.',
            'is_unique'  => 'ektp sudah terdaftar di akun lain.'
        ],
        'fullname' => [
            'required'   => 'fullname required.',
        ],
        'gender' => [
            'required'   => 'gender required.',
        ],
        'place_birth' => [
            'required'   => 'place_birth required.',
        ],
        'date_birth' => [
            'required'   => 'date_birth required.',
        ],
        'address' => [
            'required'   => 'address required.',
        ],
        'district' => [
            'required'   => 'district required.',
        ],
        'village' => [
            'required'   => 'village required.',
        ],
        'city' => [
            'required'   => 'city required.',
        ],
        'province' => [
            'required'   => 'province required.',
        ],
        'marital_status' => [
            'required'   => 'marital_status required.',
        ],
        'email' => [
            'required'   => 'email required.',
        ],
        'phone' => [
            'required'   => 'phone required.',
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
