<?php

namespace Payroll\Perm\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;

class Perm extends BaseController{
    protected $db;
    protected $perm;
    protected $table;
    protected $model;
    protected $module_id;
    protected $modules;
    public function __construct(){
        if (!auth()->loggedIn()) { 
            return redirect()->to('login');
        }
        $this->db = db_connect();
        $this->perm = new UserPerm();
        $this->table = 'grade_views';
        $this->module_id = 39;
        $this->modules = $this->perm->getModule($this->module_id);
    }
    public function index($group_id=0){ 
        $data['parent'] = $this->modules['menu_label'];
        $data['title'] = $this->modules['label'];
        $data['db'] = $this->db;
        $data['perm'] = $this->perm->getPerm($this->module_id);
        $data['group_id'] = $group_id;
        $data['groups']=$this->db->query('select * from groups WHERE active=1')->getResultArray();
        $data['grades']=$this->db->query('select * from grades WHERE active=1')->getResultArray();
        return view("\Payroll\Perm\Views\dataview",$data);
	}
    public function update($group_id){
        if($this->request->getpost('save')&&$group_id>0){
			$grade_id=$this->request->getpost('grade_id');
            $r=$this->request->getpost('r');
            $count=count($this->request->getpost('grade_id'));
            for($x=0;$x<$count;$x++){
                $qrycheck=$this->db->query("select grade_id from ".$this->table." where grade_id=".$grade_id[$x]." and group_id=".$group_id."");
                if($qrycheck->getNumRows()==1){
                    $data=array(
                        'r'=>(isset($r[$grade_id[$x]])?$r[$grade_id[$x]]:0),
                    );
                    $builder = $this->db->table($this->table);
                    $builder->where('grade_id', $grade_id[$x]);
                    $builder->where('group_id', $group_id);
                    $builder->update($data);
                }else{
                    $data=array(
                        'grade_id'=>$grade_id[$x],
                        'group_id'=>$group_id,
                        'r'=>(isset($r[$grade_id[$x]])?$r[$grade_id[$x]]:0),
                    );
                    $builder = $this->db->table($this->table);
                    $builder->replace($data);
                }
            }
			return redirect()->to("/gradeview/".$group_id);
		}
	}
}