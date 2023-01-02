<?php

namespace Master\Branch\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use Master\Branch\Models\MBranch;

class Branch extends BaseController{
    protected $db;
    protected $perm;
    protected $table;
    protected $model;
    protected $module_id;
    protected $modules;
    public function __construct(){
        $this->db = db_connect();
        $this->perm = new UserPerm();
        $this->table = 'branchs';
        $this->model = new MBranch();
        $this->module_id = 4;
        $this->modules = $this->perm->getModule($this->module_id);
    }
    public function index(){
        if (auth()->loggedIn()) {
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = $this->modules['label'];
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['isMobile']=$this->request->getUserAgent()->isMobile();
            return view("\Master\Branch\Views\dataview",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function get_data(){
        $w=" WHERE TRUE";
		if($this->request->getPost('sname'))$w.=" and name like '%".$this->request->getPost('sname')."%'";
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $offset = ($page-1) * $rows;

        $results = array();
        $sql="select * from ".$this->table;
        
        $result['total'] = $this->db->query($sql)->getNumRows();
        
        $sqldata=$sql."$w order by $sort $order limit $offset,$rows";
        $data=[];
        foreach($this->db->query($sqldata)->getResultArray() as $row){
            $row['ck']=$row['id'];
            $data[]=$row;
        }
        $results=array_merge($result,array('rows'=>$data));
		return $this->response->setJSON($results);
	}
    public function create(){
        $data = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'province' => $this->request->getPost('province'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'limit_distances' => $this->request->getPost('limit_distances')
        ];
        if ($this->model->save($data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            return $this->response->setJSON([
                'success'=>true,
                'message'=>'Data Berhasil Dibuat',
            ]);
        }
	}
    public function update($id=null){
        $data = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'province' => $this->request->getPost('province'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'limit_distances' => $this->request->getPost('limit_distances')
        ];
        if ($this->model->update($id, $data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            return $this->response->setJSON([
                'success'=>true,
                'message'=>'Data Berhasil Dibuat',
            ]);
        }
	}
    public function delete($id=null){
        $this->model->delete($id);
		return $this->response->setJSON(array('success'=>true,'message'=>'Data Berhasil Dihapus'));
	}
}