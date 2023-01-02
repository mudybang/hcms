<?php

namespace Modules\Employee\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\UploadFile;
use App\Libraries\UniqueValidator;
use Modules\Employee\Models\MEmployee;
use Modules\Employee\Models\MEmployeeHistory;

class EmployeeHistory extends BaseController{
    protected $db;
    protected $perm;
    protected $model;
    protected $bio;
    protected $table;
    protected $module_id;
    protected $modules;
    public function __construct(){
        $this->db           = db_connect();
        $this->perm         = new UserPerm;
        $this->employee     = new MEmployee;
        $this->model        = new MEmployeeHistory;
        $this->table        = 'employee_histories';
        $this->module_id    = 13;
        $this->modules      = $this->perm->getModule($this->module_id);
        $this->uploadfile   = new UploadFile;
        $this->unique       = new UniqueValidator;
    }
    public function index($employee_id){
        if (auth()->loggedIn()) {
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = 'History';
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['employee_id']=$employee_id;
            $data['isMobile']=$this->request->getUserAgent()->isMobile();
            $data['edit']=$this->employee->find($employee_id);
            $data['histories']=$this->db->query("SELECT a.*,d.name department_name,g.name grade_name,
                j.title jobtitle, s.label employment_status, b.name branch_name, p.name project_name
            FROM ".$this->table." a
                LEFT JOIN departments d ON a.department_id=d.id
                LEFT JOIN grades g ON a.grade_id=g.id
                LEFT JOIN jobtitles j ON a.jobtitle_id=j.id
                LEFT JOIN employmentstatuses s ON a.employment_status_id=s.id
                LEFT JOIN branchs b ON a.branch_id=b.id
                LEFT JOIN projects p ON a.project_id=p.id
            WHERE a.employee_id=$employee_id")->getResultArray();
            return view("\Modules\Employee\Views\history",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function create($employee_id){
        $unique=$this->unique->two_fields($this->table,['employee_id'=>$employee_id,'start_date'=>$this->request->getpost('start_date')]);
        if($unique['check']===false){
            return $this->response->setJSON(['success'=>false,'errorMessage'=>$unique['errorMessage']]);
        }
		$data=array(
            "employee_id"=>$employee_id,
            "tag_history"=>$this->request->getpost('tag_history'),
            "start_date"=>$this->request->getpost('start_date'),
            "department_id"=>$this->request->getpost('department_id'),
            "grade_id"=>$this->request->getpost('grade_id'),
            "jobtitle_id"=>$this->request->getpost('jobtitle_id'),
            "employment_status_id"=>$this->request->getpost('employment_status_id'),
            "branch_id"=>$this->request->getpost('branch_id'),
            "project_id"=>$this->request->getpost('project_id'),
            "note"=>$this->request->getpost('note'),
		);
		if($this->model->insert($data)){
            $this->syncdata($employee_id);
            $id = $this->model->getInsertID();
            $upload=$this->uploadfile->single_upload($id,'history');
            if($upload['success']===true){
                if(isset($upload['filename'])){
                    $this->model->update($id,['attachment'=>$upload['filename']]);
                }
            }else{
                $this->model->delete($id);
                return $this->response->setJSON(['success'=>false,'errorMessage'=>$upload['errorMessage']]); 
            }
            return $this->response->setJSON(['success'=>true]);
		}else{
            return $this->response->setJSON(['success'=>false,'errorMessages'=>'Input Failed']);
        }
	}
	public function delete($employee_id){
        $id=$this->request->getpost('id');
        $row=$this->model->find($id);
        if($this->model->delete($id)){
            $this->syncdata($employee_id);
            if(isset($row['attachment'])&&file_exists(FCPATH.'/uploads/employees/history/'.$row['attachment'])){
                unlink(FCPATH.'/uploads/employees/history/'.$row['attachment']);
            }
            return $this->response->setJSON(['success'=>true]);
        }
		return $this->response->setJSON(['success'=>false,'errorMessages'=>['Delete Failed']]);
    }
    public function syncdata($employee_id){
        $lasthistory=$this->db->table('employee_histories')->orderBy('start_date','DESC')->getWhere(['employee_id'=>$employee_id])->getRowArray();
        if($lasthistory['tag_history']=='Resign'){
            $this->employee->update($employee_id,[
                "active"=>0,
            ]);
        }else{
            $this->employee->update($employee_id,[
                "department_id"=>$lasthistory['department_id']??0,
                "jobtitle_id"=>$lasthistory['jobtitle_id']??0,
                "grade_id"=>$lasthistory['grade_id']??0,
                "employment_status_id"=>$lasthistory['employment_status_id']??0,
                "branch_id"=>$lasthistory['branch_id']??0,
                "project_id"=>$lasthistory['project_id']??0,
            ]);
        }
    }
    public function uploadfile($employee_id,$id){
        $img = $this->request->getFile('userfile');
        if(!$img->isValid()){
            return ['success'=>true];
        }
        if($img->getClientExtension()=='pdf'){
            $validationRule = [
                'userfile' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[userfile]'
                        . '|mime_in[userfile,application/pdf,application/x-pdf]'
                        . '|max_size[userfile,100]'
                ],
            ];
        }else{
            $validationRule = [
                'userfile' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[userfile]'
                        . '|is_image[userfile]'
                        . '|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                        . '|max_size[userfile,100]'
                        . '|max_dims[userfile,1024,768]',
                ],
            ];
        }
        if (! $this->validate($validationRule)) {
            return ['success'=>false,'errorMessages' => $this->validator->getErrors()];
        }
        if (! $img->hasMoved()) {
            $newname=md5($id).'.'.$img->getClientExtension();
            $img->move(WRITEPATH . 'uploads/employees/history', $newname, true);
            $data['attachment']=$newname;
            if($this->model->update($id,$data)){
                return ['success'=>true];
            }else{
                return ['success'=>false,'errorMessages'=>['Upload Failed']];
            }
        }
        return ['success'=>false,'errorsMessages' => ['The file has already been moved.']];
    }
}