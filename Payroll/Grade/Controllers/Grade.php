<?php

namespace Payroll\Grade\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use Payroll\Grade\Models\MGrade;

class Grade extends BaseController{
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
        $this->table = 'grades';
        $this->model = new MGrade();
        $this->module_id = 36;
        $this->modules = $this->perm->getModule($this->module_id);
    }
    public function index(){
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }
        $data['parent'] = $this->modules['menu_label'];
        $data['title'] = $this->modules['label'];
        $data['db'] = $this->db;
        $data['perm'] = $this->perm->getPerm($this->module_id);
        $data['isMobile']=$this->request->getUserAgent()->isMobile();
        return view("\Payroll\Grade\Views\dataview",$data);
	}
    public function get_data(){
        $w=" WHERE active=1";
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
            $row['base_sallary_']='Rp. '. number_format($row['base_sallary']);
            $row['ic_prorate']=$row['prorate']=='1'?'
				<i class="fas fa-check text-success"></i>':
				'<i class="fas fa-times text-danger"></i>';
            $row['component_plus']='';
            $row['component_minus']='';
            $qcomponent=$this->db->query('select a.component_id,name,label,plus,a.active from grade_payrollcomponents a
                LEFT JOIN payrollcomponents b ON a.component_id=b.id
                WHERE a.active=1 AND b.active=1 AND grade_id="'.$row['id'].'"');
            foreach($qcomponent->getResultArray()as $rowcomponent){
                $row[clearstr($rowcomponent['label'])]=$rowcomponent['component_id'];
                $row['component_'.$rowcomponent['component_id']]=$rowcomponent['active'];
                if($rowcomponent['plus']==1){
                    $row['component_plus'].=$rowcomponent['name'].', ';
                }else{
                    $row['component_minus'].=$rowcomponent['name'].', ';
                }
                $row['component_plus_']=rtrim($row['component_plus'],', ');
                $row['component_minus_']=rtrim($row['component_minus'],', ');
            }
            $label=$this->db->query('select label from payrollcomponents GROUP BY label');
			foreach($label->getResultArray()as $label){
				$components=$this->db->table('payrollcomponents')->getWhere(array('label'=>$label['label']));
				if($components->getNumRows()>0){
					foreach($components->getResultArray()as $component){
                        if($this->db->table('grade_payrollcomponents')->getWhere(array(
                                'component_id'=>$component['id'],
                                'grade_id'=>$row['id']
                            )
                        )->getNumRows()>0){
                            $row[easyui_clearstr($label['label'])]=$component['id'];
                        }
					}
				}
			}
            $data[]=$row;
        }
        $results=array_merge($result,array('rows'=>$data));
		return $this->response->setJSON($results);
	}
    public function create(){
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'base_sallary' => $this->request->getPost('base_sallary'),
            'prorate' => $this->request->getPost('prorate')
        ];
        if ($this->model->save($data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $id = $this->model->getInsertID();
            $this->db->table('grade_payrollcomponents')->where('grade_id',$id)->delete();
            $gcomponents=$this->db->query('select label from payrollcomponents GROUP BY label');
            foreach($gcomponents->getResultArray()as $gcomponent){
                if($this->request->getPost(easyui_clearstr($gcomponent['label']))>0){
                    $this->db->table('grade_payrollcomponents')->insert([
                        'component_id'=>$this->request->getPost(easyui_clearstr($gcomponent['label'])),
                        'grade_id'=>$id,
                        'active'=>1
                    ]);
                }
            }
            return $this->response->setJSON([
                'success'=>true,
                'message'=>'Data Berhasil Dibuat',
            ]);
        }
	}
    public function update($id=null){
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'base_sallary' => $this->request->getPost('base_sallary'),
            'prorate' => $this->request->getPost('prorate')
        ];
        if ($this->model->update($id, $data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $this->db->table('grade_payrollcomponents')->where('grade_id',$id)->delete();
            $gcomponents=$this->db->query('select label from payrollcomponents GROUP BY label');
            foreach($gcomponents->getResultArray()as $gcomponent){
                if($this->request->getPost(easyui_clearstr($gcomponent['label']))>0){
                    $this->db->table('grade_payrollcomponents')->insert(array(
                        'component_id'=>$this->request->getPost(easyui_clearstr($gcomponent['label'])),
                        'grade_id'=>$id,
                        'active'=>1
                        )
                    );
                }
            }
            return $this->response->setJSON([
                'success'=>true,
                'message'=>'Data Berhasil Dibuat',
            ]);
        }
	}
    public function delete($id=null){
        $this->db->table('grade_payrollcomponents')->where('grade_id',$id)->delete();
        $this->model->delete($id);
		return $this->response->setJSON(array('success'=>true,'message'=>'Data Berhasil Dihapus'));
	}
}