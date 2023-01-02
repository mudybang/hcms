<?php

namespace Auth\Perm\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;

class PermController extends BaseController{
    protected $db;
    protected $perm;
    protected $table;
    protected $model;
    protected $module_id;
    protected $modules;
    public function __construct(){
        $this->db = db_connect();
        $this->perm = new UserPerm();
        $this->table = 'perms';
        $this->module_id = 3;
        $this->modules = $this->perm->getModule($this->module_id);
    }
    public function index($group_id=0){
        if (auth()->loggedIn()) {   
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = $this->modules['label'];
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['group_id'] = $group_id;
            $data['groups']=$this->db->query('select * from groups')->getResultArray();
            $data['modules']=$this->getModules($group_id);
            return view("\Auth\Perm\Views\dataview",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function update($group_id){
        if($this->request->getpost('save')&&$group_id>0){
			$module_id=$this->request->getpost('module_id');
            $c=$this->request->getpost('c');
            $r=$this->request->getpost('r');
            $u=$this->request->getpost('u');
            $d=$this->request->getpost('d');
            $r_all=$this->request->getpost('r_all');
            $a=$this->request->getpost('a');
            $excel=$this->request->getpost('excel');
            $count=count($this->request->getpost('module_id'));
            for($x=0;$x<$count;$x++){
                $qrycheck=$this->db->query("select module_id from perms where module_id=".$module_id[$x]." and group_id=".$group_id."");
                if($qrycheck->getNumRows()==1){
                    $data=array(
                        'c'=>(isset($c[$module_id[$x]])?$c[$module_id[$x]]:0),
                        'r'=>(isset($r[$module_id[$x]])?$r[$module_id[$x]]:0),
                        'u'=>(isset($u[$module_id[$x]])?$u[$module_id[$x]]:0),
                        'd'=>(isset($d[$module_id[$x]])?$d[$module_id[$x]]:0),
                        'r_all'=>(isset($r_all[$module_id[$x]])?$r_all[$module_id[$x]]:0),
                        'a'=>(isset($a[$module_id[$x]])?$a[$module_id[$x]]:0),
                        'excel'=>(isset($excel[$module_id[$x]])?$excel[$module_id[$x]]:0),
                    );
                    $builder = $this->db->table($this->table);
                    $builder->where('module_id', $module_id[$x]);
                    $builder->where('group_id', $group_id);
                    $builder->update($data);
                }else{
                    $data=array(
                        'module_id'=>$module_id[$x],
                        'group_id'=>$group_id,
                        'c'=>(isset($c[$module_id[$x]])?$c[$module_id[$x]]:0),
                        'r'=>(isset($r[$module_id[$x]])?$r[$module_id[$x]]:0),
                        'u'=>(isset($u[$module_id[$x]])?$u[$module_id[$x]]:0),
                        'd'=>(isset($d[$module_id[$x]])?$d[$module_id[$x]]:0),
                        'r_all'=>(isset($r_all[$module_id[$x]])?$r_all[$module_id[$x]]:0),
                        'a'=>(isset($a[$module_id[$x]])?$a[$module_id[$x]]:0),
                        'excel'=>(isset($excel[$module_id[$x]])?$excel[$module_id[$x]]:0),
                    );
                    $builder = $this->db->table($this->table);
                    $builder->replace($data);
                }
            }
			return redirect()->to("/perm/".$group_id);
		}
	}

    function getModules($group_id){
		$data=array();
		$menus=$this->db->query("select id menu_id,label from menus");
		foreach($menus->getResultArray() as $menu){
			$sql="select id,label,menu_id from modules m
				where menu_id='".$menu['menu_id']."'
				order by id,menu_id ASC";
			$modules=$this->db->query($sql);
			if($modules->getNumRows()>0){
				$data[]=$menu;
                foreach($modules->getResultArray() as $module){
                    $qperm=$this->db->query("select * from perms where module_id=".$module['id']." and group_id=".$group_id);
                    if($qperm->getNumRows()>0){
                        $perm=$qperm->getRowArray();
                        $module['group_id']=$perm['group_id'];
                        $module['c']=$perm['c'];
                        $module['r']=$perm['r'];
                        $module['u']=$perm['u'];
                        $module['d']=$perm['d'];
                        $module['r_all']=$perm['r_all'];
                        $module['a']=$perm['a'];
                        $module['excel']=$perm['excel'];
                    }
                    $data[]=$module;
                }
			}else{
                
            }
		}
		return $data;
	}
    public function test(){
        echo json_encode($Bio->find(2));
    }
}