<?php

namespace Master\Project\Models;

use CodeIgniter\Model;

class MProject extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'projects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','code','branch_id','address','city','province','day_cut_off','latitude','longitude','limit_distances'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required',
        'code' => 'required',
        'province' => 'required',
        'branch_id' => 'required',
    ];
    protected $validationMessages   = [
        'name' => [
            'required'   => 'name required.',
        ],
        'code' => [
            'required'   => 'code required.',
        ],
        'province' => [
            'required'   => 'province required.',
        ],
        'branch_id' => [
            'required'   => 'branch required.',
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
