<?php

namespace Modules\Employee\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use Modules\Employee\Models\MEmployee;
use Modules\Employee\Models\MEmployeeEducation;
use Modules\Employee\Models\MEmployeeExperience;

class EmployeeEduexp extends BaseController{
    protected $db;
    protected $perm;
    protected $model;
    protected $bio;
    protected $module_id;
    protected $modules;
    public function __construct(){
        $this->db           = db_connect();
        $this->perm         = new UserPerm;
        $this->education    = new MEmployeeEducation;
        $this->experience   = new MEmployeeExperience;
        $this->module_id    = 13;
        $this->modules      = $this->perm->getModule($this->module_id);
    }
    public function index($employee_id){
        if (auth()->loggedIn()) {
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = 'Education & Experience';
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['employee_id']=$employee_id;
            $data['isMobile']=$this->request->getUserAgent()->isMobile();
            $data['educations']=$this->db->query("select a.*,concat(name,'-',level)label from employee_educations a
                LEFT JOIN educations ed ON a.education_id=ed.id WHERE a.employee_id=$employee_id")->getResultArray();
            $data['experiences']=$this->experience->where('employee_id',$employee_id)->findAll();
            return view("\Modules\Employee\Views\\eduexp",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function create_edu($employee_id){
		$data=array(
            "employee_id"=>$employee_id,
            "education_id"=>$this->request->getpost('education_id'),
            "major"=>$this->request->getpost('major'),
            "institution_name"=>$this->request->getpost('institution_name'),
            "year_graduate"=>$this->request->getpost('year_graduate'),
            "certification_number"=>$this->request->getpost('certification_number'),
		);
		if($this->education->insert($data)){
            $this->sync_edu($employee_id);
            return $this->response->setJSON(['success'=>true]);
		}
        return $this->response->setJSON(['success'=>false,'errorMsg'=>'Input Failed']);
	}
	public function delete_edu($employee_id){
        if($this->education->delete($this->request->getpost('id'))){
            $this->sync_edu($employee_id);
            return $this->response->setJSON(['success'=>true]);
        }
		return $this->response->setJSON(['success'=>false,'errorMsg'=>'Input Failed']);
    }
    public function sync_edu($employee_id){
        $lastedu=$this->db->table('employee_educations')->orderBy('education_id','DESC')->getWhere(['employee_id'=>$employee_id])->getRowArray();
        $employee= new MEmployee;
        $employee->update($employee_id,['education_id'=>$lastedu['education_id']??0]);
    }
    public function create_exp($employee_id){
		$data=array(
            "employee_id"=>$employee_id,
            "company_name"=>$this->request->getpost('company_name'),
            "company_desc"=>$this->request->getpost('company_desc'),
            "jobtitle"=>$this->request->getpost('jobtitle'),
            "year_start"=>$this->request->getpost('year_start'),
            "year_end"=>$this->request->getpost('year_end'),
            "job_desc"=>$this->request->getpost('job_desc'),
            "sallary"=>$this->request->getpost('sallary'),
            "reason_leave"=>$this->request->getpost('reason_leave')
		);
		if($this->experience->insert($data)){
            return $this->response->setJSON(['success'=>true]);
		}
        return $this->response->setJSON(['success'=>false,'errorMsg'=>'Input Failed']);
	}
	public function delete_exp($employee_id){
		if($this->experience->delete($this->request->getpost('id'))){
            return $this->response->setJSON(['success'=>true]);
        }
		return $this->response->setJSON(['success'=>false,'errorMsg'=>'Input Failed']);
	}
}