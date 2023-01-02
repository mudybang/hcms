<?php 
namespace App\Libraries;

class UniqueValidator {
    protected $db;
    public function __construct(){
        $this->db = db_connect();
    }
    public function two_fields($table, $data){
        if($this->db->table($table)->getWhere($data)->getNumRows()>0){
            return ['check'=>false,'errorMessage'=>'Data exist.'];
        }
        return ['check'=>true];
    }
}