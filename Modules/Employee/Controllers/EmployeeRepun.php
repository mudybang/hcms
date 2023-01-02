<?php

namespace Modules\Employee\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\UploadFile;
use Modules\Employee\Models\MEmployee;
use Modules\Employee\Models\MEmployeeReward;
use Modules\Employee\Models\MEmployeePunishment;

class EmployeeRepun extends BaseController{
    protected $db;
    protected $perm;
    protected $employee;    
    protected $reward;
    protected $punishment;
    protected $module_id;
    protected $modules;
    protected $uploadfile;
    public function __construct(){
        $this->db           = db_connect();
        $this->perm         = new UserPerm;
        $this->employee     = new MEmployee;
        $this->reward       = new MEmployeeReward;
        $this->punishment   = new MEmployeePunishment;
        $this->module_id    = 13;
        $this->modules      = $this->perm->getModule($this->module_id);
        $this->uploadfile   = new UploadFile;
    }
    public function index($employee_id){
        if (auth()->loggedIn()) {
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = 'Reward & Punishment';
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['employee_id']=$employee_id;
            $data['eid_number']=$this->employee->find($employee_id)['eid_number'];
            $data['isMobile']=$this->request->getUserAgent()->isMobile();
            $data['rewards']=$this->reward->where('employee_id',$employee_id)->findAll();
            $data['punishments']=$this->punishment->where('employee_id',$employee_id)->findAll();
            return view("\Modules\Employee\Views\\repun",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function create_reward($employee_id){
		$data=array(
            "employee_id"=>$employee_id,
            "title"=>$this->request->getpost('title'),
            "description"=>$this->request->getpost('description'),
            "given_date"=>$this->request->getpost('given_date'),
            "given_by"=>$this->request->getpost('given_by'),
		);
		if($this->reward->insert($data)){
            $id = $this->reward->getInsertID();
            $upload=$this->uploadfile->single_upload($id,'reward',$this);
            if($upload['success']===true){
                if(isset($upload['filename'])){
                    $this->reward->update($id,['attachment'=>$upload['filename']]);
                }
            }else{
                $this->reward->delete($id);
                return $this->response->setJSON(['success'=>false,'errorMessage'=>$upload['errorMessage']]); 
            }
            return $this->response->setJSON(['success'=>true]);
		}
        return $this->response->setJSON(['success'=>false,'errorMesage'=>'Input Failed']);
	}
	public function delete_reward($employee_id){
        if($this->reward->delete($this->request->getpost('id'))){
            if(isset($row['attachment'])&&file_exists(FCPATH.'/uploads/employees/reward/'.$row['attachment'])){
                unlink(FCPATH.'/uploads/employees/reward/'.$row['attachment']);
            }
            return $this->response->setJSON(['success'=>true]);
        }
		return $this->response->setJSON(['success'=>false,'errorMesages'=>['Input Failed']]);
    }
    public function create_punishment($employee_id){
		$data=array(
            "employee_id"=>$employee_id,
            "title"=>$this->request->getpost('title'),
            "description"=>$this->request->getpost('description'),
            "given_date"=>$this->request->getpost('given_date'),
            "given_by"=>$this->request->getpost('given_by'),
		);
		if($this->punishment->insert($data)){
            $id = $this->punishment->getInsertID();
            $upload=$this->uploadfile->single_upload($id,'punishment');
            if($upload['success']==true){
                if(isset($upload['filename'])){
                    $this->punishment->update($id,['attachment'=>$upload['filename']]);
                }
            }else{
                $this->punishment->delete($id);
                return $this->response->setJSON(['success'=>false,'errorMessage'=>$upload['errorMessage']]);
            }
            return $this->response->setJSON(['success'=>true]);
		}
        return $this->response->setJSON(['success'=>false,'errorMessage'=>'Input Failed']);
	}
	public function delete_punishment($employee_id){
		if($this->punishment->delete($this->request->getpost('id'))){
            if(isset($row['attachment'])&&file_exists(FCPATH.'/uploads/employees/punishment/'.$row['attachment'])){
                unlink(FCPATH.'/uploads/employees/punishment/'.$row['attachment']);
            }
            return $this->response->setJSON(['success'=>true]);
        }
		return $this->response->setJSON(['success'=>false,'errorMsg'=>'Input Failed']);
	}
}