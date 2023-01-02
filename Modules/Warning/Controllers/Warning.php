<?php

namespace Modules\Warning\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\UploadFile;
use Modules\Warning\Models\MWarning;

class Warning extends BaseController{
    protected $db;
    protected $perm;
    protected $table;
    protected $model;
    protected $module_id;
    protected $modules;
    public function __construct(){
        $this->db           = db_connect();
        $this->perm         = new UserPerm();
        $this->table        = 'employee_warnings';
        $this->model        = new MWarning();
        $this->module_id    = 28;
        $this->modules      = $this->perm->getModule($this->module_id);
        $this->uploadfile   = new UploadFile;
    }
    public function index(){
        if (auth()->loggedIn()===false) {
            return redirect()->to('login');
        }
        $data['parent'] = $this->modules['menu_label'];
        $data['title'] = $this->modules['label'];
        $data['db'] = $this->db;
        $data['perm'] = $this->perm->getPerm($this->module_id);
        $data['isMobile']=$this->request->getUserAgent()->isMobile();
        return view("\Modules\Warning\Views\dataview",$data);
	}
    public function get_data(){
        $w=" WHERE TRUE";
		if($this->request->getpost('seid_number'))$w.=" and eid_number like '%".$this->request->getpost('seid_number')."%'";
        if($this->request->getpost('sfullname'))$w.=" and fullname like '%".$this->request->getpost('sfullname')."%'";
        if($this->request->getpost('sdepartment_id'))$w.=" and e.department_id='".$this->request->getpost('sdepartment_id')."' OR d.parent_id='".$this->request->getpost('sdepartment_id')."'";
        if($this->request->getpost('sbranch_id'))$w.=" and e.branch_id='".$this->request->getpost('sbranch_id')."'";
        if($this->request->getpost('sjobtitle_id'))$w.=" and e.jobtitle_id='".$this->request->getpost('sjobtitle_id')."'";
        if($this->request->getpost('sgrade_id'))$w.=" and e.grade_id='".$this->request->getpost('sgrade_id')."'";
        if($this->request->getpost('sproject_id'))$w.=" and e.project_id='".$this->request->getpost('sproject_id')."'";
        if($this->request->getpost('sis_all')==0)$w.=" and e.active=1";
        if($this->request->getpost('fdate')){
			if($this->request->getpost('fdate')&&$this->request->getpost('ldate')){
				$w.=" and (a.given_date BETWEEN '".$this->request->getpost('fdate')."' AND '".$this->request->getpost('ldate')."')";
			}else{
				$w.=" and a.given_date > '".$this->request->getpost('fdate')."'";
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
        ";
        $result['total'] = $this->db->query($sql)->getNumRows();
        
        $sqldata=$sql."$w order by $sort $order limit $offset,$rows";
        $data=[];
        foreach($this->db->query($sqldata)->getResultArray() as $row){
            $row['ck']=$row['id'];
            $row['ic_download']=$row['attachment']&&file_exists(FCPATH.'/uploads/employees/warning/'.$row['attachment'])?
                '<a target="_blank" href="'.base_url("uploads/employees/warning/".$row['attachment']).'"><i class="fas fa-download"></i></a>':
                '--no-attachment--';
            $data[]=$row;
        }
        $results=array_merge($result,array('rows'=>$data));
		return $this->response->setJSON($results);
	}
    public function create(){
        if($this->request->getPost('number')){
            $number=$this->request->getPost('number');
            $type='direct';
        }else{
            $employee_id=$this->request->getPost('employee_id');
            $given_date=$this->request->getPost('given_date');
            $query=$this->db->query('select MAX(number)number from '.$this->table.' WHERE employee_id='.$employee_id." AND number=1 AND given_date > DATE_SUB('$given_date', INTERVAL 6 MONTH)");
            $query2=$this->db->query('select MAX(number)number from '.$this->table.' WHERE employee_id='.$employee_id." AND number=2 AND type='direct' AND given_date > DATE_SUB('$given_date', INTERVAL 6 MONTH)");
            if($query->getNumRows()>0||$query2->getNumRows()>0){
                $query3=$this->db->query('select MAX(number)number from '.$this->table.' WHERE employee_id='.$employee_id." AND given_date > DATE_SUB('$given_date', INTERVAL 6 MONTH)");
                $number=$query3->getRowArray()['number'];
                $number+=1;
            }else{
                $number=1;
            }
            $type='auto';
        }
        $data = [
            'employee_id'   => $this->request->getPost('employee_id'),
            'number'        => $number,
            'type'          => $type,
            'title'         => $this->request->getPost('title'),
            'description'   => $this->request->getPost('description'),
            'given_date'    => $this->request->getPost('given_date'),
            'given_by'      => $this->request->getPost('given_by')
        ];
        if ($this->model->save($data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $id = $this->model->getInsertID();
            $upload=$this->uploadfile->single_upload($id,'warning');
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
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'given_date' => $this->request->getPost('given_date'),
            'given_by' => $this->request->getPost('given_by')
        ];
        if ($this->model->update($id, $data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $upload=$this->uploadfile->single_upload($id,'warning');
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
            if(isset($row['attachment'])&&file_exists(FCPATH.'/uploads/employees/warning/'.$row['attachment'])){
                unlink(FCPATH.'/uploads/employees/warning/'.$row['attachment']);
            }
        }
		return $this->response->setJSON(array('success'=>true));
	}
}