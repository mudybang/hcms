<?php
namespace App\Libraries;

class GenerateCode {
    protected $db;
    public function __construct(){
        $this->db = db_connect();
    }
    public function gen_eid_number($join_date=''){
        if($join_date=='')return '';
        $arrjoin_date=explode('-',$join_date);
        if($arrjoin_date[0]>1900){
            $y=substr($arrjoin_date[0],-2);
            $ym=$y.$arrjoin_date[1];
        }else{
            return 0;
        }
        $sql="select id from employees where eid_number LIKE '$y%' AND CHAR_LENGTH(eid_number)=9";
        $query=$this->db->query($sql);
        $number=$query->getNumRows()+1;
        $check=1;
        while($check>0){
            $qrycheck=$this->db->query("SELECT eid_number from employees WHERE eid_number REGEXP '^$y\[\[:alnum:\]\]+$number$'");
            $check=$qrycheck->getNumRows();
            if($check==0){
                $key=str_pad($number, 5, "0", STR_PAD_LEFT);
                $gen=$ym.$key;
                break;
            }else{
                $number++;
            }
        }
        return $gen;
    }
    public function gen_employee_contract($id,$start_date){
        $contract=$this->db->table('employee_contracts')->getWhere(['id'=>$id])->getRowArray();
        $vars=explode('-',$start_date);
        $type=$contract['employment_status_id']==1?'PKWTT':'PKWT';
        return str_pad($id,5,'0',STR_PAD_LEFT).'/HRD/'.$type.'/'.$this->numberToRoman($vars[1]).'/'.$vars[0];
    }
    public function gen_employee_history($id,$start_date){
        $contract=$this->db->table('employee_contracts')->getWhere(['id'=>$id])->getRowArray();
        $vars=explode('-',$start_date);
        return str_pad($id,5,'0',STR_PAD_LEFT).'/HRD/SPT/'.$this->numberToRoman($vars[1]).'/'.$vars[0];
    }
    public function numberToRoman($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}