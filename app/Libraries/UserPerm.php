<?php 
namespace App\Libraries;

class UserPerm {
    protected $db;
    protected $table;
    protected $user;
    public function __construct(){
        $this->db = db_connect();
        $this->table = 'perms';
        $this->user = auth()->user();
    }
    public function checkR($id_module){
		if($id_module==0){
			return array('r'=>0);
		}
        $sql="SELECT r FROM ".$this->table." WHERE module_id=$id_module AND group_id=".$this->user->group_id;
        $query=$this->db->query($sql);
        $row = $query->getRowArray();
        if (isset($row)&&$row['r']>0){
            return $row;
        }else{
            return redirect()->to('login');
        }
    }
	public function getPerm($id_module){
		$sql="SELECT c,r,u,d,r_all,a,excel FROM ".$this->table." WHERE module_id=$id_module AND group_id=".$this->user->group_id;
        $query=$this->db->query($sql);
        $row = $query->getRowArray();
        return $row;
	}
    public function getModule($id=0){
        $module=$this->db->table('modules')
            ->select('modules.*, menus.label as menu_label')
            ->join('menus', 'menus.id = modules.menu_id', 'left')
            ->getWhere(['modules.id'=>$id])
            ->getRowArray();
        return $module;
    }
}