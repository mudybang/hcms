<?php

namespace Modules\Employee\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\GenerateCode;
use Modules\Employee\Models\MEmployee;

class EmployeeStatus extends BaseController{
    protected $db;
    protected $perm;
    protected $table;
    protected $model;
    protected $module_id;
    protected $modules;
    public function __construct(){
        $this->db = db_connect();
        $this->perm  = new UserPerm();
        $this->table = 'employees';
        $this->model = new MEmployee();
        $this->module_id = 13;
        $this->modules = $this->perm->getModule($this->module_id);
    }
    public function index($employee_id){
        if (auth()->loggedIn()) {
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = $this->modules['label'];
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['employee_id']=$employee_id;
            $data['isMobile']=$this->request->getUserAgent()->isMobile();
            $data['edit']=$this->db->query("SELECT e.*,eb.*,
                d.name department_name,d.parent_id parent_department_id,g.name grade_name,j.title jobtitle,j.report_level,es.label employee_status,
                b.name branch_name,p.name project_name,ed.level education_name
                FROM ".$this->table." e
                LEFT JOIN employee_bio eb ON e.id=eb.employee_id
                LEFT JOIN employmentstatuses es ON e.employment_status_id=es.id
                LEFT JOIN jobtitles j ON e.jobtitle_id=j.id
                LEFT JOIN educations ed ON e.education_id=ed.id
                LEFT JOIN grades g ON e.grade_id=g.id
                LEFT JOIN branchs b ON e.branch_id=b.id
                LEFT JOIN projects p ON e.project_id=p.id
                LEFT JOIN departments d ON e.department_id=d.id
            WHERE e.id=".$employee_id)->getRowArray();
            return view("\Modules\Employee\Views\\employment",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function update($employee_id=0){
        $data=[
            'bank_account_number'   => $this->request->getPost('bank_account_number'),
            'bank_account_name'     => $this->request->getPost('bank_account_name'),
            'bank_name'             => $this->request->getPost('bank_name'),
            'npwp_number'           => $this->request->getPost('npwp_number'),
            'ptkp_code'             => $this->request->getPost('ptkp_code'),
        ];
		if($this->model->update($employee_id,$data)){
            session()->setFlashdata('message', 'Data Updated');
            return redirect()->to(base_url('employee/employment/'.$employee_id));
        }
        session()->setFlashdata('errorMessage', ['Update Failed']);
        return redirect()->to(base_url('employee/employment/'.$employee_id));
    }
}