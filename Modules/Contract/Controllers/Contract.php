<?php

namespace Modules\Contract\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\GenerateCode;
use App\Libraries\UploadFile;
use Modules\Contract\Models\MContract;

class Contract extends BaseController{
    protected $db;
    protected $perm;
    protected $table;
    protected $model;
    protected $module_id;
    protected $modules;
    public function __construct(){
        if (auth()->loggedIn()===false) {
            return redirect()->to('login');
        }
        $this->db           = db_connect();
        $this->perm         = new UserPerm();
        $this->table        = 'employee_contracts';
        $this->model        = new MContract();
        $this->module_id    = 14;
        $this->modules      = $this->perm->getModule($this->module_id);
        $this->uploadfile   = new UploadFile;
    }
    public function index(){
        $data['parent'] = $this->modules['menu_label'];
        $data['title'] = $this->modules['label'];
        $data['db'] = $this->db;
        $data['perm'] = $this->perm->getPerm($this->module_id);
        $data['isMobile']=$this->request->getUserAgent()->isMobile();
        return view("\Modules\Contract\Views\dataview",$data);
	}
    public function get_data(){
        $w=" WHERE TRUE";
		if($this->request->getpost('seid_number'))$w.=" and eid_number like '%".$this->request->getpost('seid_number')."%'";
        if($this->request->getpost('sfullname'))$w.=" and fullname like '%".$this->request->getpost('sfullname')."%'";
        if($this->request->getpost('sdepartment_id'))$w.=" and a.department_id='".$this->request->getpost('sdepartment_id')."' OR d.parent_id='".$this->request->getpost('sdepartment_id')."'";
        if($this->request->getpost('sbranch_id'))$w.=" and a.branch_id='".$this->request->getpost('sbranch_id')."'";
        if($this->request->getpost('sjobtitle_id'))$w.=" and a.jobtitle_id='".$this->request->getpost('sjobtitle_id')."'";
        if($this->request->getpost('sgrade_id'))$w.=" and a.grade_id='".$this->request->getpost('sgrade_id')."'";
        if($this->request->getpost('sproject_id'))$w.=" and a.project_id='".$this->request->getpost('sproject_id')."'";
        if($this->request->getpost('semployment_status_id'))$w.=" and employment_status_id ='".$this->request->getpost('semployment_status_id')."'";
        if($this->request->getpost('sis_all')==0)$w.=" and e.active=1";
        if($this->request->getpost('fdate')){
			if($this->request->getpost('fdate')&&$this->request->getpost('ldate')){
				$w.=" and (a.join_date BETWEEN '".$this->request->getpost('fdate')."' AND '".$this->request->getpost('ldate')."')";
			}else{
				$w.=" and a.join_date > '".$this->request->getpost('fdate')."'";
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
            LEFT JOIN branchs b ON a.branch_id=b.id
            LEFT JOIN departments d ON a.department_id=d.id
            LEFT JOIN grades g ON a.grade_id=g.id
            LEFT JOIN jobtitles j ON a.jobtitle_id=j.id
            LEFT JOIN projects p ON a.project_id=p.id
            LEFT JOIN employmentstatuses es ON a.employment_status_id=es.id
        ";
        $result['total'] = $this->db->query($sql)->getNumRows();
        
        $sqldata=$sql."$w order by $sort $order limit $offset,$rows";
        $data=[];
        foreach($this->db->query($sqldata)->getResultArray() as $row){
            $row['ck']=$row['id'];
            $row['ic_signed']=$row['signed']==1?'<i class="fas fa-check"></i>':
                '<i class="fas fa-times"></i>';
            $row['ic_draft']='<a target="_blank" href="'.base_url("contract/print/".$row['id']).'"><i class="fab fa-firstdraft"></i></a>';
            $row['ic_download']=$row['attachment']&&file_exists(FCPATH.'/uploads/employees/contract/'.$row['attachment'])?
                '<a target="_blank" href="'.base_url("uploads/employees/contract/".$row['attachment']).'"><i class="fas fa-download"></i></a>':
                '--no-attachment--';
            $data[]=$row;
        }
        $results=array_merge($result,array('rows'=>$data));
		return $this->response->setJSON($results);
	}
    public function create(){
        $GenerateCode   =new GenerateCode;
        $data = [
            'employee_id' => $this->request->getPost('employee_id'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'department_id' => $this->request->getPost('department_id')??0,
            'grade_id' => $this->request->getPost('grade_id')??0,
            'jobtitle_id' => $this->request->getPost('jobtitle_id')??0,
            'branch_id' => $this->request->getPost('branch_id')??0,
            'project_id' => $this->request->getPost('project_id')??0,
            'employment_status_id' => $this->request->getPost('employment_status_id')??0,
            'signed' => $this->request->getPost('signed')??0,
            'placement' => $this->request->getPost('placement')??0,
        ];
        if ($this->model->save($data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $id = $this->model->getInsertID();
            $this->model->update($id,['number'=>$GenerateCode->gen_employee_contract($id,$this->request->getPost('start_date'))]);
            $upload=$this->uploadfile->single_upload($id,'contract');
            if($upload['success']===true){
                if(isset($upload['filename'])){
                    $this->model->update($id,['attachment'=>$upload['filename']]);
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
            'employee_id'   => $this->request->getPost('employee_id'),
            'number'        => $GenerateCode->gen_employee_contract($id,$this->request->getPost('start_date')),
            'start_date'    => $this->request->getPost('start_date'),
            'end_date'      => $this->request->getPost('end_date'),
            'department_id' => $this->request->getPost('department_id')??0,
            'grade_id'      => $this->request->getPost('grade_id')??0,
            'jobtitle_id'   => $this->request->getPost('jobtitle_id')??0,
            'branch_id'     => $this->request->getPost('branch_id')??0,
            'project_id'    => $this->request->getPost('project_id')??0,
            'employment_status_id' => $this->request->getPost('employment_status_id')??0,
            'signed'        => $this->request->getPost('signed')??0,
            'placement'     => $this->request->getPost('placement')??0,
        ];
        if ($this->model->update($id, $data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $upload=$this->uploadfile->single_upload($id,'contract');
            if($upload['success']===true){
                if(isset($upload['filename'])){
                    $this->model->update($id,['attachment'=>$upload['filename']]);
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
            if(isset($row['attachment'])&&file_exists(FCPATH.'/uploads/employees/contract/'.$row['attachment'])){
                unlink(FCPATH.'/uploads/employees/contract/'.$row['attachment']);
            }
        }
		return $this->response->setJSON(array('success'=>true));
	}
    public function print($id=null){
        $row=$this->db->query("select a.*,ektp_number,gender,place_birth,date_birth,eb.address,marital_status,eb.phone,eid_number,fullname,join_date,d.name department_name,g.name grade_name,j.title jobtitle,es.label employee_status,contract_type,
        b.name branch_name,p.name project_name from ".$this->table." a
            LEFT JOIN employees e ON a.employee_id=e.id
            LEFT JOIN employee_bio eb ON a.employee_id=eb.employee_id
            LEFT JOIN branchs b ON a.branch_id=b.id
            LEFT JOIN departments d ON a.department_id=d.id
            LEFT JOIN grades g ON a.grade_id=g.id
            LEFT JOIN jobtitles j ON a.jobtitle_id=j.id
            LEFT JOIN projects p ON a.project_id=p.id
            LEFT JOIN employmentstatuses es ON a.employment_status_id=es.id
        WHERE a.id=$id")->getRowArray();
        $row['place_date_birth']=$row['place_birth'].' ,'.$row['date_birth'];
        $data['title'] = "Contract Letter";
        $data['company']= $this->db->table('companies')->getWhere(['id'=>1])->getRowArray();
        $data['employee'] = $row;
        if($row['contract_type']==='PKWT')
            return view("\Modules\Contract\Views\\template_pkwt",$data);
        else
            return view("\Modules\Contract\Views\\template_pkwtt",$data);
	}
}