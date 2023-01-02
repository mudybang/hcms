<?php

namespace Payroll\Component\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use Payroll\Component\Models\MComponent;

class Deduction extends BaseController{
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
        $this->table = 'payrollcomponents';
        $this->model = new MComponent();
        $this->module_id = 38;
        $this->modules = $this->perm->getModule($this->module_id);
    }
    public function index(){
        $data['parent'] = $this->modules['menu_label'];
        $data['title']  = $this->modules['label'];
        $data['db']     = $this->db;
        $data['perm']   = $this->perm->getPerm($this->module_id);
        $data['isMobile']=$this->request->getUserAgent()->isMobile();
        return view("\Payroll\Component\Views\deduction",$data);
	}
    public function get_data(){
        $w=" WHERE plus=0";
		if($this->request->getPost('sname'))$w.=" and name like '%".$this->request->getPost('sname')."%'";
        if($this->request->getPost('slabel'))$w.=" and label like '%".$this->request->getPost('slabel')."%'";
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $offset = ($page-1) * $rows;

        $results = array();
        $sql="select * from ".$this->table."";
        
        $result['total'] = $this->db->query($sql)->getNumRows();
        
        $sqldata=$sql."$w order by $sort $order limit $offset,$rows";
        $data=[];
        foreach($this->db->query($sqldata)->getResultArray() as $row){
            $row['ck']=$row['id'];
            $row['rp_value_']='Rp. '. number_format($row['rp_value']);
            $row['rp_value_bp_']='Rp. '. number_format($row['rp_value_bp']);
            $row['min_rp_value_']='Rp. '. number_format($row['min_rp_value']);
            $row['limit_base_value']='Rp. '. number_format($row['limit_base_value']);
            $data[]=$row;
        }
        $results=array_merge($result,array('rows'=>$data));
		return $this->response->setJSON($results);
	}
    public function create(){
        $data = [
            "name"          =>$this->request->getpost('name'),
            "plus"          =>0,
            "label"         =>$this->request->getpost('label'),
            "level"         =>"Pay Grade",
            "formula"       =>$this->request->getpost('formula'),
            "rp_value"      =>$this->request->getpost('rp_value'),
            "formula_bp"    =>$this->request->getpost('formula_bp'),
            "rp_value_bp"   =>$this->request->getpost('rp_value_bp'),
            "min_rp_value"  =>$this->request->getpost('min_rp_value'),
            "limit_base_value"=>$this->request->getpost('limit_base_value'),
			"active"=>1,
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
            "name"          =>$this->request->getpost('name'),
            "label"         =>$this->request->getpost('label'),
            "formula"       =>$this->request->getpost('formula'),
            "rp_value"      =>$this->request->getpost('rp_value'),
            "formula_bp"    =>$this->request->getpost('formula_bp'),
            "rp_value_bp"   =>$this->request->getpost('rp_value_bp'),
            "min_rp_value"  =>$this->request->getpost('min_rp_value'),
            "limit_base_value"=>$this->request->getpost('limit_base_value'),
        ];
        if ($this->model->update($id, $data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()
            ]);
        }else{
            return $this->response->setJSON([
                'success'=>true,
                'message'=>'Data Berhasil Dibuat',
            ]);
        }
	}
    public function delete($id=null){
        $this->model->delete($id);
		return $this->response->setJSON(['success'=>true,'message'=>'Data Berhasil Dihapus']);
	}
}