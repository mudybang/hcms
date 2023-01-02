<?php

namespace Modules\Employee\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\UploadFile;
use Modules\Employee\Models\MEmployee;
use Modules\Employee\Models\MEmployeeBio;

class EmployeeProfile extends BaseController{
    protected $db;
    protected $perm;
    protected $table;
    protected $model;
    protected $bio;
    protected $module_id;
    protected $modules;
    protected $uploadfile;
    public function __construct(){
        $this->db           = db_connect();
        $this->perm         = new UserPerm;
        $this->table        = 'employees';
        $this->model        = new MEmployee;
        $this->bio          = new MEmployeeBio;
        $this->module_id    = 13;
        $this->modules      = $this->perm->getModule($this->module_id);
        $this->uploadfile   = new UploadFile;
    }
    public function index($employee_id=0){
        if (auth()->loggedIn()) {
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = 'Profile';
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['isMobile']=$this->request->getUserAgent()->isMobile();
            $data['employee_id']=$employee_id;
            //$data['edit']=$this->bio->find($employee_id);
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
            return view("\Modules\Employee\Views\profile",$data);
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
            $data=[
                'fullname'      => $this->request->getPost('fullname'),
                'gender'        => $this->request->getPost('gender'),
                'place_birth'   => $this->request->getPost('place_birth'),
                'date_birth'    => $this->request->getPost('date_birth'),
                'religion'      => $this->request->getPost('religion'),
                'address'       => $this->request->getPost('address'),
                'district'      => $this->request->getPost('district'),
                'village'       => $this->request->getPost('village'),
                'city'          => $this->request->getPost('city'),
                'province'      => $this->request->getPost('province'),
                'postcode'      => $this->request->getPost('postcode'),
                'marital_status'=> $this->request->getPost('marital_status'),
                'email'         => $this->request->getPost('email'),
                'phone'         => $this->request->getPost('phone')
            ];
            $selected=$this->bio->find($employee_id);
            if($selected['ektp_number']!=$this->request->getPost('ektp_number')){
                $data['ektp_number']=$this->request->getPost('ektp_number');
            }
            if($this->bio->update($employee_id,$data)){
                $dir_scheme=['img_profile','attachment_cv'];
                $uploads=$this->uploadfile->multiple_upload($employee_id,$dir_scheme);
                if($uploads['success'] === true){
                    if(sizeof($uploads['files'])>0){
                        foreach($uploads['files'] as $key=>$file){
                            $this->bio->update($employee_id,[$dir_scheme[$key]=>$file]);
                        }
                    }
                    session()->setFlashdata('message', 'Data Updated ');
                    session()->setFlashdata('warningMessages', $uploads['warningMessages']);
                    return redirect()->to(base_url('employee/profile/'.$employee_id));
                }
                session()->setFlashdata('errorMessages', $uploads['errorsMessages']);
                return redirect()->to(base_url('employee/profile/'.$employee_id));
            }
        }
        session()->setFlashdata('errorMessages', ['Update Failed']);
        return redirect()->to(base_url('employee/profile/'.$employee_id));
    }
}