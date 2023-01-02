<?php

namespace Auth\User\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;

class UserController extends BaseController{
    protected $db;
    protected $perm;
    protected $table;
    protected $model;
    protected $groups;
    protected $module_id;
    protected $modules;
    public function __construct(){
        $this->db = db_connect();
        $this->perm = new UserPerm();
        $this->table = 'users';
        $this->model = new UserModel;
        $this->groups = ['superadmin','admin','developer','user','beta'];
        $this->module_id = 1;
        $this->modules = $this->perm->getModule($this->module_id);
    }
    public function test(){
        $row_auth_logins=$this->db->query("select date from auth_logins where user_id=1 ORDER BY date DESC")->getRowArray();
        echo $row_auth_logins['date'];
    }
    public function index(){
        if (auth()->loggedIn()) {
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = $this->modules['label'];
            $data['groups'] = $this->groups;
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['isMobile']=$this->request->getUserAgent()->isMobile();
            return view("\Auth\User\Views\dataview",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function get_data(){
        $w=" WHERE u.active=1";
		if($this->request->getPost('susername'))$w.=" and username like '%".$this->request->getPost('susername')."%'";
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'u.id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $offset = ($page-1) * $rows;

        $results = array();
        $sql="select u.*,secret email,g.label group_label FROM ".$this->table." u
			LEFT JOIN auth_identities au on u.id=au.user_id
            LEFT JOIN groups g on u.group_id=g.id";
        
        $result['total'] = $this->db->query($sql)->getNumRows();
        
        $sqldata=$sql."$w order by $sort $order limit $offset,$rows";
        $data=[];
        foreach($this->db->query($sqldata)->getResultArray() as $row){
            $row['ck']=$row['id'];
            foreach($this->groups as $group){
                $row[$group]=0;                
                $row['ic_'.$group]='<i class="fas fa-times text-danger"></i>';
                if($this->db->query("select * from auth_groups_users where user_id=".$row['id']." and `group`='".$group."'")->getNumRows()>0){
                    $row[$group]=1;
                    $row['ic_'.$group]='<i class="fas fa-check text-success"></i>';
                }
            }
            $row_auth_logins=$this->db->query("select date from auth_logins where user_id=".$row['id']." ORDER BY date DESC")->getRowArray();
            if(isset($row_auth_logins)){
                $row['last_active']=$row_auth_logins['date'];
            }
            $data[]=$row;
        }
        $results=array_merge($result,array('rows'=>$data));
		return $this->response->setJSON($results);
	}
    public function create(){
        $validation = $this->validate([
            'username' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Username required.'
                ]
            ],
            'email' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Email required.'
                ]
            ],
            'password' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Password required.'
                ]
            ],
        ]);
        if(!$validation) {
            return $this->response->setJSON(array('success'=>false,'message'=>$this->validator));
        } else {
            $user = new User([
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'group_id' => $this->request->getPost('group_id'),
                'active' => 1
            ]);
            $this->model->save($user);
            $user = $this->model->findById($this->model->getInsertID());

            $selectedonce=false;
            foreach($this->groups as $group){
                if($this->request->getPost($group)==='1'){
                    $user->addGroup($group);
                    $selectedonce=true;
                }
            }
            if(!$selectedonce){
                $this->model->addToDefaultGroup($user);
            }

            return $this->response->setJSON(array('success'=>true,'message'=>'Data Berhasil Dibuat','token'=>csrf_hash()));
        }
	}
    public function update($id=null){
        $validation = $this->validate([
            'username' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Username required.'
                ]
            ],
            'email' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Email required.'
                ]
            ],
        ]);
        if(!$validation) {
            return $this->response->setJSON(array('success'=>false,'message'=>$this->validator));
        } else {
            $user  = $this->model->findById($id);
            $data=[
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'group_id' => $this->request->getPost('group_id')
            ];
            if($this->request->getPost('password')!==''){
                $data['password']=$this->request->getPost('password');
            }

            $user->fill($data);
            $this->model->save($user);
            foreach($this->groups as $group){
                if($this->request->getPost($group)==='1'){
                    $user->addGroup($group);
                }else{
                    $user->removeGroup($group);
                }
            }

            return $this->response->setJSON(array('success'=>true,'message'=>'Data Berhasil Diupdate',''));
        }		
	}
    public function delete($id=null){
        $this->model->delete($id, true);
		return $this->response->setJSON(array('success'=>true,'message'=>'Data Berhasil Dihapus'));
	}
}