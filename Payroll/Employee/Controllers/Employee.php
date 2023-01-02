<?php

namespace Payroll\Employee\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use Payroll\Employee\Models\MEmployeeSallary;

class Employee extends BaseController{
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
        $this->table = 'employee_sallary';
        $this->model = new MEmployeeSallary();
        $this->module_id = 21;
        $this->modules = $this->perm->getModule($this->module_id);
    }
    public function index(){
        $data['parent'] = $this->modules['menu_label'];
        $data['title'] = $this->modules['label'];
        $data['db'] = $this->db;
        $data['perm'] = $this->perm->getPerm($this->module_id);
        $data['isMobile']=$this->request->getUserAgent()->isMobile();
        return view("\Payroll\Employee\Views\dataview",$data);
	}
    public function get_data(){
        $w=" WHERE TRUE";
		if($this->request->getpost('seid_number'))$w.=" and eid_number like '%".$this->request->getpost('seid_number')."%'";
        if($this->request->getpost('sfullname'))$w.=" and fullname like '%".$this->request->getpost('sfullname')."%'";
        if($this->request->getpost('sdepartment_id'))$w.=" and e.department_id='".$this->request->getpost('sdepartment_id')."' OR d.parent_id='".$this->request->getpost('sdepartment_id')."'";
        if($this->request->getpost('sbranch_id'))$w.=" and e.branch_id='".$this->request->getpost('sbranch_id')."'";
        if($this->request->getpost('sjobtitle_id'))$w.=" and e.jobtitle_id='".$this->request->getpost('sjobtitle_id')."'";
        if($this->request->getpost('semployee_id'))$w.=" and e.employee_id='".$this->request->getpost('semployee_id')."'";
        if($this->request->getpost('sproject_id'))$w.=" and e.project_id='".$this->request->getpost('sproject_id')."'";
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'employee_id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $offset = ($page-1) * $rows;

        $results = array();
        $sql="select a.*,eid_number,fullname,join_date,d.name department_name,g.name grade_name,j.title jobtitle,es.label employee_status,
        b.name branch_name,p.name project_name from ".$this->table." a
            LEFT JOIN employees e ON a.employee_id=e.id
            LEFT JOIN employee_bio eb ON a.employee_id=eb.employee_id
            LEFT JOIN branchs b ON e.branch_id=b.id
            LEFT JOIN departments d ON e.department_id=d.id
            LEFT JOIN grades g ON e.grade_id=g.id
            LEFT JOIN jobtitles j ON e.jobtitle_id=j.id
            LEFT JOIN projects p ON e.project_id=p.id
            LEFT JOIN employmentstatuses es ON e.employment_status_id=es.id
        ";
        
        $result['total'] = $this->db->query($sql)->getNumRows();
        
        $sqldata=$sql."$w order by $sort $order limit $offset,$rows";
        $data=[];
        foreach($this->db->query($sqldata)->getResultArray() as $row){
            $row['ck']=$row['employee_id'];
            $row['base_sallary_']='Rp. '. number_format($row['base_sallary']);
            $row['ic_prorate']=$row['prorate']=='1'?'
				<i class="fas fa-check"></i>':
				'<i class="fas fa-times"></i>';
            $row['component_plus']='';
            $row['component_minus']='';
            $qcomponent=$this->db->query('select a.component_id,name,label,plus,a.active from employee_payrollcomponents a
                LEFT JOIN payrollcomponents b ON a.component_id=b.id
                WHERE a.active=1 AND b.active=1 AND employee_id="'.$row['ck'].'"');
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
                        if($this->db->table('employee_payrollcomponents')->getWhere(array(
                                'component_id'=>$component['id'],
                                'employee_id'=>$row['ck']
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
            'employee_id' => $this->request->getPost('employee_id'),
            'base_sallary' => $this->request->getPost('base_sallary'),
            'prorate' => $this->request->getPost('prorate')??0,
        ];
        if ($this->model->save($data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $id = $this->request->getPost('employee_id');
            $this->db->table('employee_payrollcomponents')->where('employee_id',$id)->delete();
            $gcomponents=$this->db->query('select label from payrollcomponents GROUP BY label');
            foreach($gcomponents->getResultArray()as $gcomponent){
                if($this->request->getPost(easyui_clearstr($gcomponent['label']))>0){
                    $this->db->table('employee_payrollcomponents')->insert([
                        'component_id'=>$this->request->getPost(easyui_clearstr($gcomponent['label'])),
                        'employee_id'=>$id,
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
            'base_sallary' => $this->request->getPost('base_sallary'),
            'prorate' => $this->request->getPost('prorate'),
        ];
        if ($this->model->update($id, $data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $this->db->table('employee_payrollcomponents')->where('employee_id',$id)->delete();
            $gcomponents=$this->db->query('select label from payrollcomponents GROUP BY label');
            foreach($gcomponents->getResultArray()as $gcomponent){
                if($this->request->getPost(easyui_clearstr($gcomponent['label']))>0){
                    $this->db->table('employee_payrollcomponents')->insert(array(
                        'component_id'=>$this->request->getPost(easyui_clearstr($gcomponent['label'])),
                        'employee_id'=>$id,
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
        $this->model->delete($id);
		return $this->response->setJSON(array('success'=>true,'message'=>'Data Berhasil Dihapus'));
	}
}