<?php

namespace Modules\Insurance\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\GenerateCode;
use App\Libraries\UploadFile;
use Modules\Insurance\Models\MInsurance;

class Insurance extends BaseController{
    protected $db;
    protected $perm;
    protected $table;
    protected $model;
    protected $module_id;
    protected $modules;
    public function __construct(){        
        $this->db           = db_connect();
        $this->perm         = new UserPerm();
        $this->table        = 'employee_insurances';
        $this->model        = new MInsurance();
        $this->module_id    = 22;
        $this->modules      = $this->perm->getModule($this->module_id);
        $this->uploadfile   = new UploadFile;
    }
    public function index(){
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }
        $data['perm'] = $this->perm->getPerm($this->module_id);
        $data['parent'] = $this->modules['menu_label'];
        $data['title'] = $this->modules['label'];
        $data['db'] = $this->db;
        $data['isMobile']=$this->request->getUserAgent()->isMobile();
        return view("\Modules\Insurance\Views\dataview",$data);
	}
    public function get_data(){
        $w=" WHERE sibling=''";
		if($this->request->getpost('seid_number'))$w.=" and eid_number like '%".$this->request->getpost('seid_number')."%'";
        if($this->request->getpost('sfullname'))$w.=" and fullname like '%".$this->request->getpost('sfullname')."%'";
        if($this->request->getpost('sdepartment_id'))$w.=" and e.department_id='".$this->request->getpost('sdepartment_id')."' OR d.parent_id='".$this->request->getpost('sdepartment_id')."'";
        if($this->request->getpost('sbranch_id'))$w.=" and e.branch_id='".$this->request->getpost('sbranch_id')."'";
        if($this->request->getpost('sjobtitle_id'))$w.=" and e.jobtitle_id='".$this->request->getpost('sjobtitle_id')."'";
        if($this->request->getpost('sgrade_id'))$w.=" and e.grade_id='".$this->request->getpost('sgrade_id')."'";
        if($this->request->getpost('sproject_id'))$w.=" and e.project_id='".$this->request->getpost('sproject_id')."'";
        if($this->request->getpost('sinsurance_name'))$w.=" and insurance_name LIKE '%".$this->request->getpost('sinsurance_name')."%'";
        if($this->request->getpost('sis_all')==0)$w.=" and e.active=1";
        if($this->request->getpost('fdate')){
			if($this->request->getpost('fdate')&&$this->request->getpost('ldate')){
				$w.=" and (a.register_date BETWEEN '".$this->request->getpost('fdate')."' AND '".$this->request->getpost('ldate')."')";
			}else{
				$w.=" and a.register_date > '".$this->request->getpost('fdate')."'";
			}
		}
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
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
            $w ";
        $result['total'] = $this->db->query($sql)->getNumRows();
        
        $sqldata=$sql."order by $sort $order limit $offset,$rows";
        $data=[];
        foreach($this->db->query($sqldata)->getResultArray() as $row){
            $row['ck']=$row['id'];
            $row['ic_given']=$row['given_date']>'0000-00-00'?'<i class="fas fa-check"></i>':
                '<i class="fas fa-times"></i>';
            $row['ic_download']=$row['receipn']&&file_exists(FCPATH.'/uploads/employees/insurance/'.$row['receipn'])?
                '<a target="_blank" href="'.base_url("uploads/employees/insurance/".$row['receipn']).'"><i class="fas fa-download"></i></a>':
                '--no-receipn--';
            $siblings=$this->db->query("select * FROM employee_siblings WHERE employee_id='".$row['employee_id']."' AND `sibling` NOT IN('Mother','Father')");
            foreach($siblings->getResultArray()as $sibling){
                $siblinginsurance=$this->db->table('employee_insurances')->getWhere(['employee_id'=>$row['employee_id'],'sibling'=>$sibling['sibling']])->getRowArray();
                $row['fullname_'.easyui_clearstr($sibling['sibling'])]=$sibling['fullname']??'';
                $row['card_number_'.easyui_clearstr($sibling['sibling'])]=$siblinginsurance['card_number']??'';
                $row['register_date_'.easyui_clearstr($sibling['sibling'])]=$siblinginsurance['register_date']??'';
                $row['expired_date_'.easyui_clearstr($sibling['sibling'])]=$siblinginsurance['expired_date']??'';
            }
            $data[]=$row;
        }
        $results=array_merge($result,array('rows'=>$data));
		return $this->response->setJSON($results);
	}
    public function create(){
        $GenerateCode   =new GenerateCode;
        $data = [
            'employee_id' => $this->request->getPost('employee_id'),
            'card_number' => $this->request->getPost('card_number'),
            'insurance_name' => $this->request->getPost('insurance_name'),
            'register_date' => $this->request->getPost('register_date'),
            'expired_date' => $this->request->getPost('expired_date'),
            'given_date' => $this->request->getPost('given_date'),
        ];
        if ($this->model->save($data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $id = $this->model->getInsertID();
            $this->updatesibling($this->request->getPost('employee_id'));
            $upload=$this->uploadfile->single_upload($id,'insurance');
            if($upload['success']===true){
                if(isset($upload['filename'])){
                    $this->model->update($id,['receipn'=>$upload['filename']]);
                }
            }else{
                return $this->response->setJSON(['success'=>false,'errorMessages'=>$upload['errorMessage']]); 
            }
            return $this->response->setJSON(['success'=>true,]);
        }
	}
    public function update($id=null){
        $GenerateCode   =new GenerateCode;
        $data = [
            'card_number' => $this->request->getPost('card_number'),
            'insurance_name' => $this->request->getPost('insurance_name'),
            'register_date' => $this->request->getPost('register_date'),
            'expired_date' => $this->request->getPost('expired_date'),
            'given_date' => $this->request->getPost('given_date'),
        ];
        if ($this->model->update($id, $data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $this->updatesibling($this->request->getPost('employee_id'));
            $upload=$this->uploadfile->single_upload($id,'insurance');
            if($upload['success']===true){
                if(isset($upload['filename'])){
                    $this->model->update($id,['receipn'=>$upload['filename']]);
                }
            }else{
                return $this->response->setJSON(['success'=>false,'errorMessages'=>[$upload['errorMessage']]]); 
            }
            return $this->response->setJSON(['success'=>true]);
        }
	}
    public function delete($id=null){
        $row=$this->model->find($id);
        if($this->model->delete($id)){
            if(isset($row['receipn'])&&file_exists(FCPATH.'/uploads/employees/insurance/'.$row['receipn'])){
                unlink(FCPATH.'/uploads/employees/insurance/'.$row['receipn']);
            }
        }
		return $this->response->setJSON(array('success'=>true));
	}
    public function getsiblingfullname($id){
        $builder=$this->db->table('employee_siblings')->getWhere(['employee_id'=>$id, 'sibling'=>$this->request->getPost('sibling')]);
        if($builder->getNumRows()>0){
            $sibling=$builder->getRowArray();
            return $this->response->setJSON(array('success'=>true,'fullname'=>$sibling['fullname']));
        }
	}
    public function updatesibling($id){
        $siblings=$this->db->query("select `option` FROM options WHERE label='SIBLING' AND `option` NOT IN('Mother','Father')");
        foreach($siblings->getResultArray()as $sibling){
            $this->db->table('employee_insurances')
            ->replace([
                'employee_id'=>$id,
                'sibling'=>$sibling['option'],
                'card_number'=>$this->request->getPost('card_number_'.easyui_clearstr($sibling['option']))??'',
                'register_date'=>$this->request->getPost('register_date_'.easyui_clearstr($sibling['option']))??'',                
            ]);
        }
	}
}