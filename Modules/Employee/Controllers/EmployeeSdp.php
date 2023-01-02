<?php

namespace Modules\Employee\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\UploadFile;
use Modules\Employee\Models\MEmployee;
use Modules\Employee\Models\MEmployeeSdp;

class EmployeeSdp extends BaseController{
    protected $db;
    protected $perm;
    protected $employee;
    protected $model;
    protected $module_id;
    protected $modules;
    public function __construct(){
        $this->db           = db_connect();
        $this->perm         = new UserPerm;
        $this->employee     = new MEmployee;
        $this->model        = new MEmployeeSdp;
        $this->module_id    = 13;
        $this->modules      = $this->perm->getModule($this->module_id);
        $this->uploadfile   = new UploadFile;
    }
    public function index($employee_id){
        if (auth()->loggedIn()) {
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = 'Development';
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['employee_id']=$employee_id;
            $data['eid_number']=$this->employee->find($employee_id)['eid_number'];
            $data['isMobile']=$this->request->getUserAgent()->isMobile();
            $data['sdps']=$this->db->query("SELECT a.*,b.title FROM employee_sdps a
                LEFT JOIN sdps b ON a.sdp_id=b.id
            WHERE a.employee_id=$employee_id")->getResultArray();
            return view("\Modules\Employee\Views\sdp",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function create($employee_id){
		$data=array(
            "employee_id"=>$employee_id,
            "sdp_id"=>$this->request->getpost('sdp_id'),
            "institution_name"=>$this->request->getpost('institution_name'),
            "expired_date"=>$this->request->getpost('expired_date'),
            "attachment"=>$this->request->getpost('attachment'),
		);
		if($this->model->insert($data)){
            $id = $this->model->getInsertID();
            $upload=$this->uploadfile->single_upload($id,'sdp',$this);
            if($upload['success']===true){
                if(isset($upload['filename'])){
                    $this->model->update($id,['attachment'=>$upload['filename']]);
                }
            }else{
                $this->model->delete($id);
                return $this->response->setJSON(['success'=>false,'errorMessage'=>$upload['errorMessage']]); 
            }
            return $this->response->setJSON(['success'=>true]);
		}
        return $this->response->setJSON(['success'=>false,'errorMessages'=>'Input Failed']);
	}
	public function delete($employee_id){
        $id=$this->request->getpost('id');
        $row=$this->model->find($id);
        if($this->model->delete($id)){
            if(isset($row['attachment'])&&file_exists(FCPATH.'/uploads/employees/sdp/'.$row['attachment'])){
                unlink(FCPATH.'/uploads/employees/sdp/'.$row['attachment']);
            }
            return $this->response->setJSON(['success'=>true]);
        }
		return $this->response->setJSON(['success'=>false,'errorMessages'=>['Delete Failed']]);
    }
}