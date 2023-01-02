<?php

namespace Modules\Employee\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\UploadFile;
use Modules\Employee\Models\MEmployeeBio;
use Modules\Employee\Models\MEmployeeSibling;

class EmployeeSibling extends BaseController{
    protected $db;
    protected $perm;
    protected $model;
    protected $bio;
    protected $module_id;
    protected $modules;
    public function __construct(){
        $this->db           = db_connect();
        $this->perm         = new UserPerm;
        $this->model        = new MEmployeeSibling;
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
            $data['profile']=$this->bio->find($employee_id);
            return view("\Modules\Employee\Views\sibling",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function update($employee_id=0){
        $data=array(
            "kk_number"=>$this->request->getPost('kk_number'),
		);
		if($this->bio->update($employee_id,$data)){
            $siblings=$this->db->table('options')->getWhere(['label'=>'SIBLING']);
            foreach($siblings->getResultArray()as $sibling){
                if($this->request->getPost("fullname_".clearstr($sibling['option']))){
                    $data = array(
                        'employee_id'  => $employee_id,
                        'sibling'  => $sibling['option'],
                        'ektp_number' => $this->request->getPost("ektp_number_".clearstr($sibling['option'])),
                        'fullname' => $this->request->getPost("fullname_".clearstr($sibling['option'])),
                        'date_birth' => $this->request->getPost("date_birth_".clearstr($sibling['option'])),
                    );
                    if($this->model->getWhere(['employee_id'=>$employee_id,'sibling'=>$sibling['option']])->getNumRows()>0){
                        $this->model
                            ->where('employee_id',$employee_id)
                            ->where('sibling',$sibling['option'])
                            ->set($data)
                            ->update();
                    }else{
                        $this->model->insert($data);
                    }
                }
            }
            $dir_scheme=['attachment_ektp','attachment_kk'];
            $uploads=$this->uploadfile->multiple_upload($employee_id,$dir_scheme);
            if($uploads['success'] === true){
                if(sizeof($uploads['files'])>0){
                    foreach($uploads['files'] as $key=>$file){
                        $this->bio->update($employee_id,[$dir_scheme[$key]=>$file]);
                    }
                }
                session()->setFlashdata('message', 'Data Updated ');
                session()->setFlashdata('warningMessages', $uploads['warningMessages']);
                return redirect()->to(base_url('employee/sibling/'.$employee_id));
            }
            session()->setFlashdata('errorMessages', $uploads['errorsMessages']);
            return redirect()->to(base_url('employee/sibling/'.$employee_id));
		}
        session()->setFlashdata('errorMessage', ['Update Failed']);
        return redirect()->to(base_url('employee/sibling/'.$employee_id));
    }
}