<?php

namespace Modules\Employee\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\GenerateCode;
use App\Libraries\UploadFile;
use Modules\Employee\Models\MEmployee;
use Modules\Employee\Models\MEmployeeBio;
use Modules\Employee\Models\MEmployeeEducation;
use Modules\Employee\Models\MEmployeeHistory;

class Employee extends BaseController{
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
        $this->Bio            =new MEmployeeBio;
        $this->Education      =new MEmployeeEducation;
        $this->History        =new MEmployeeHistory;
        $this->module_id = 13;
        $this->modules = $this->perm->getModule($this->module_id);
        $this->uploadfile   = new UploadFile;
    }
    public function index(){
        if (auth()->loggedIn()) {
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = $this->modules['label'];
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['isMobile']=$this->request->getUserAgent()->isMobile();
            return view("\Modules\Employee\Views\dataview",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function profile($id=0){
        if (auth()->loggedIn()) {
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = 'Profile';
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['isMobile']=$this->request->getUserAgent()->isMobile();
            $data['id']=$id;
            $data['profile']=$this->db->query("SELECT e.*,eb.*,
                d.name department_name,g.name grade_name,j.title jobtitle,es.label employee_status,
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
            WHERE e.id=".$id)->getRowArray();
            return view("\Modules\Employee\Views\profile",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function get_data(){
        $w=" WHERE e.approved=1";
		if($this->request->getpost('sektp_number'))$w.=" and ektp_number like '%".$this->request->getpost('sektp_number')."%'";
        if($this->request->getpost('sfullname'))$w.=" and fullname like '%".$this->request->getpost('sfullname')."%'";
        if($this->request->getpost('seducation_level'))$w.=" and education_level='".$this->request->getpost('seducation_level')."'";
        if($this->request->getpost('sjobtitle_id'))$w.=" and e.jobtitle_id='".$this->request->getpost('sjobtitle_id')."'";
        if($this->request->getpost('sdepartment_id'))$w.=" and e.department_id='".$this->request->getpost('sdepartment_id')."' OR d.parent_id='".$this->request->getpost('sid_department')."'";
        if($this->request->getpost('sgrade_id'))$w.=" and e.grade_id='".$this->request->getpost('sgrade_id')."'";
        if($this->request->getpost('sbranch_id'))$w.=" and e.branch_id='".$this->request->getpost('sbranch_id')."'";
        if($this->request->getpost('sproject_id'))$w.=" and e.project_id='".$this->request->getpost('sproject_id')."'";
        if($this->request->getpost('seid_number'))$w.=" and eid_number like '%".$this->request->getpost('seid_number')."%'";
        if($this->request->getpost('semployment_status_id'))$w.=" and employment_status_id='".$this->request->getpost('semployment_status_id')."'";
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
        $sql="SELECT e.*,eb.*,
            d.name department_name,g.name grade_name,j.title jobtitle,es.label employee_status,
            b.name branch_name,p.name project_name,ed.level education_name
            FROM ".$this->table." e
            LEFT JOIN employee_bio eb ON e.id=eb.employee_id
            LEFT JOIN employmentstatuses es ON e.employment_status_id=es.id
            LEFT JOIN jobtitles j ON e.jobtitle_id=j.id
            LEFT JOIN educations ed ON e.education_id=ed.id
            LEFT JOIN grades g ON e.grade_id=g.id
            LEFT JOIN branchs b ON e.branch_id=b.id
            LEFT JOIN projects p ON e.project_id=p.id
            LEFT JOIN departments d ON e.department_id=d.id";
        
        $result['total'] = $this->db->query($sql)->getNumRows();
        
        $sqldata=$sql."$w order by $sort $order limit $offset,$rows";
        $data=[];
        foreach($this->db->query($sqldata)->getResultArray() as $row){
            $row['ck']=$row['id'];
            $row['img_profile']=
                $row['img_profile']&&file_exists(FCPATH.'/uploads/employees/profile/'.$row['img_profile'])?
                '<div class="image">
                    <img style="width:21px;height:21px" class="img-circle elevation-2" src="'.base_url().'/uploads/employees/profile/'.$row['img_profile'].'" />
                </div>':
                '<i class="fas fa-user-circle"></i>';
            $row['address_']=$row['address'].', '.$row['village'].', '.$row['district'].', '.$row['city'].', '.$row['province'];
            $row['place_day_birth']=$row['place_birth'].', '.$row['date_birth'];
            $row['contact']=$row['email'].', '.$row['phone'];
            $row['attachment_']=$row['attachment_cv']&&file_exists(FCPATH.'uploads/employees/cv/'.$row['attachment_cv'])?
                '<a target="_blank" href="'.base_url("uploads/employees/cv/".$row['attachment_cv']).'"><i class="fas fa-download"></i></a>':
                '--no-attachment--';
            $row['ic_detail']="<a href='".base_url()."/employee/profile/".$row['ck']."'>
                    <i class='fas fa-file'></i>
                </a>";
            $data[]=$row;
        }
        $results=array_merge($result,array('rows'=>$data));
		return $this->response->setJSON($results);
	}
    public function create(){
        $GenerateCode   =new GenerateCode;
        $data = [
            'eid_number' => $GenerateCode->gen_eid_number($this->request->getPost('join_date')),
            'join_date' => $this->request->getPost('join_date'),
            'department_id' => $this->request->getPost('department_id')??0,
            'jobtitle_id' => $this->request->getPost('jobtitle_id')??0,
            'grade_id' => $this->request->getPost('grade_id')??0,
            'branch_id' => $this->request->getPost('branch_id')??0,
            'project_id' => $this->request->getPost('project_id')??0,
            'employment_status_id' => $this->request->getPost('employment_status_id')??0,
            'education_id' => $this->request->getPost('education_id')??0,
        ];
        if ($this->model->save($data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $id = $this->model->getInsertID();
            $data=[
                'employee_id'   => $id,
                'ektp_number'   => $this->request->getPost('ektp_number'),
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
                'phone'         => $this->request->getPost('phone'),
            ];
            if ($this->Bio->save($data) === false) {
                $this->model->delete($id);
                return $this->response->setJSON([
                    'success'=>false,
                    'errorMessages'=>$this->Bio->errors()]);
            }else{
                $data=[
                    'tag_history'   => 'Join',
                    'start_date'    => $this->request->getPost('join_date'),
                    'employee_id'   => $id,
                    'department_id' => $this->request->getPost('department_id'),
                    'grade_id'      => $this->request->getPost('grade_id'),
                    'branch_id'     => $this->request->getPost('branch_id'),
                    'project_id'    => $this->request->getPost('project_id'),
                    'employment_status_id'    => $this->request->getPost('employment_status_id'),
                    'jobtitle_id'    => $this->request->getPost('jobtitle_id'),
                ];
                if ($this->History->save($data) === false) {
                    $this->model->delete($id);
                    $this->Bio->delete($id);
                    return $this->response->setJSON([
                        'success'=>false,
                        'errorMessages'=>$this->History->errors()]);
                }else{
                    $historyId=$this->History->getInsertID();
                    $this->History->update($historyId,['number'=>$GenerateCode->gen_employee_history($id,$this->request->getPost('start_date'))]);
                    $data=[
                        'employee_id'   => $id,
                        'education_id'    => $this->request->getPost('education_id'),
                    ];
                    if ($this->Education->save($data) === false) {
                        $this->model->delete($id);
                        $this->Bio->delete($id);
                        $this->History->delete($id);
                        return $this->response->setJSON([
                            'success'=>false,
                            'errorMessages'=>$Education->errors()]);
                    }else{
                        $dir_scheme=['img_profile','attachment_cv'];
                        $uploads=$this->uploadfile->multiple_upload($id,$dir_scheme);
                        if($uploads['success'] === true){
                            if(sizeof($uploads['files'])>0){
                                foreach($uploads['files'] as $key=>$file){
                                    $this->Bio->update($id,[$dir_scheme[$key]=>$file]);
                                }
                            }
                            if($uploads['warningMessages']){
                                return $this->response->setJSON([
                                    'success'=>true,
                                    'warningMessages'=>$uploads['warningMessages']
                                ]);
                            }
                        }
                    }
                }

            }
        }
        return $this->response->setJSON([
            'success'=>true,   
        ]);
	}
    public function update($id=null){
        $data = [
            'join_date' => $this->request->getPost('join_date'),
            'department_id' => $this->request->getPost('department_id')??0,
            'jobtitle_id' => $this->request->getPost('jobtitle_id')??0,
            'grade_id' => $this->request->getPost('grade_id')??0,
            'jobtitle_id' => $this->request->getPost('jobtitle_id')??0,
            'branch_id' => $this->request->getPost('branch_id')??0,
            'project_id' => $this->request->getPost('project_id')??0,
            'employment_status_id' => $this->request->getPost('employment_status_id')??0,
            'education_id' => $this->request->getPost('education_id')??0,
        ];
        if ($this->model->update($id,$data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
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
                'phone'         => $this->request->getPost('phone'),
            ];
            $bio=$this->Bio->find($id);
            if($bio['ektp_number']!=$this->request->getPost('ektp_number')){
                $data['ektp_number']=$this->request->getPost('ektp_number');
            }
            if ($this->Bio->update($id,$data) === false) {
                return $this->response->setJSON([
                    'success'=>false,
                    'errorMessages'=>$this->Bio->errors()]);
            }else{
                $history=$this->db->table('employee_histories')->orderBy('start_date','ASC')->getWhere(['tag_history'=>'Join','employee_id'=>$id])->getRowArray();
                $data=[
                    'tag_history'   => 'Join',
                    'start_date'    => $this->request->getPost('join_date'),
                    'employee_id'   => $id,
                    'department_id' => $this->request->getPost('department_id'),
                    'grade_id'      => $this->request->getPost('grade_id'),
                    'branch_id'     => $this->request->getPost('branch_id'),
                    'project_id'    => $this->request->getPost('project_id')??0,
                    'employment_status_id'    => $this->request->getPost('employment_status_id'),
                    'jobtitle_id'    => $this->request->getPost('jobtitle_id'),
                ];
                if ($this->History->update($history['id'],$data) === false) {
                    return $this->response->setJSON([
                        'success'=>false,
                        'errorMessages'=>$this->History->errors()]);
                }else{
                    $education=$this->db->table('employee_educations')->orderBy('year_graduate','DESC')->getWhere(['employee_id'=>$id])->getRowArray();
                    $data=[
                        'employee_id'   => $id,
                        'education_id'    => $this->request->getPost('education_id'),
                    ];
                    if ($this->Education->update($education['id'],$data) === false) {
                        return $this->response->setJSON([
                            'success'=>false,
                            'errorMessages'=>$this->Education->errors()]);
                    }else{
                        $dir_scheme=['img_profile','attachment_cv'];
                        $uploads=$this->uploadfile->multiple_upload($id,$dir_scheme);
                        if($uploads['success'] === true){
                            if(sizeof($uploads['files'])>0){
                                foreach($uploads['files'] as $key=>$file){
                                    $this->Bio->update($id,[$dir_scheme[$key]=>$file]);
                                }
                            }
                            if($uploads['warningMessages']){
                                return $this->response->setJSON([
                                    'success'=>true,
                                    'warningMessages'=>$uploads['warningMessages']
                                ]);
                            }
                        }
                    }
                }

            }
        }
        return $this->response->setJSON([
            'success'=>true,            
        ]);
	}
    public function delete($id=null){
        $this->Bio->where('employee_id', $id)->delete();
        $this->Education->where('employee_id', $id)->delete();
        $this->History->where('employee_id', $id)->delete();
        $this->model->delete($id);
		return $this->response->setJSON(array('success'=>true,'message'=>'Data Berhasil Dihapus'));
	}
}