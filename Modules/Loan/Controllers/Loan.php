<?php

namespace Modules\Loan\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\UploadFile;
use Modules\Loan\Models\MLoan;

class Loan extends BaseController{
    protected $db;
    protected $perm;
    protected $table;
    protected $model;
    protected $module_id;
    protected $modules;
    public function __construct(){
        $this->db           = db_connect();
        $this->perm         = new UserPerm();
        $this->table        = 'loans';
        $this->model        = new MLoan();
        $this->module_id    = 23;
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
        return view("\Modules\Loan\Views\dataview",$data);
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
        if($this->request->getpost('stitle')==0)$w.=" and a.title like '%".$this->request->getpost('stitle')."%'";
        if($this->request->getpost('status')){
            switch ($this->request->getPost('approval')) {
                case 'Approve':
                    $w.=" and a.approved=1";
                    break;
                case 'Reject':
                    $w.=" and a.approved=2";
                    break;
                default:
                    $w.=" and a.approved=0";
            }
        }
        if($this->request->getpost('fdate')){
			if($this->request->getpost('fdate')&&$this->request->getpost('ldate')){
				$w.=" and (a.receive_date BETWEEN '".$this->request->getpost('fdate')."' AND '".$this->request->getpost('ldate')."')";
			}else{
				$w.=" and a.receive_date > '".$this->request->getpost('fdate')."'";
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
            $row['ic_download']=$row['receipn']&&file_exists(FCPATH.'/uploads/employees/loan/'.$row['receipn'])?
                '<a target="_blank" href="'.base_url("uploads/employees/loan/".$row['receipn']).'"><i class="fas fa-download"></i></a>':
                '--no-receipn--';
            $row['rp_value_']='Rp. '.number_format($row['rp_value']);
            switch ($row['approved']) {
                case 1:
                    $row['approval']='Approve';
                    break;
                case 2:
                    $row['approval']='Reject';
                    break;
                default:
                    $row['approval']='Pending';
            }
            $data[]=$row;
        }
        $results=array_merge($result,array('rows'=>$data));
		return $this->response->setJSON($results);
	}
    public function create(){
        $status='0';
        switch ($this->request->getPost('approval')) {
            case 'Approve':
                $status='1';
                break;
            case 'Reject':
                $status='2';
                break;
            default:
                $status='0';
        }
        $data = [
            'employee_id'   => $this->request->getPost('employee_id'),
            'title'         => $this->request->getPost('title'),
            'rp_value'      => $this->request->getPost('rp_value'),
            'installment'   => $this->request->getPost('installment'),
            'note'          => $this->request->getPost('note'),
            'receive_date'  => $this->request->getPost('receive_date'),
            'approved'      => $status
            
        ];
        if ($this->model->save($data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $id = $this->model->getInsertID();
            $upload=$this->uploadfile->single_upload($id,'loan');
            if($upload['success']===true){
                if(isset($upload['filename'])){
                    $this->model->update($id,['receipn'=>$upload['filename']]);
                }
            }else{
                return $this->response->setJSON(['success'=>false,'errorMessages'=>$upload['errorMessage']]); 
            }
            return $this->response->setJSON(['success'=>true,]);
        }
	}
    public function update($id=null){
        $status='0';
        switch ($this->request->getPost('approval')) {
            case 'Approve':
                $status='1';
                break;
            case 'Reject':
                $status='2';
                break;
            default:
                $status='0';
        }
        $data = [
            'title'         => $this->request->getPost('title'),
            'rp_value'      => $this->request->getPost('rp_value'),
            'installment'   => $this->request->getPost('installment'),
            'note'          => $this->request->getPost('note'),
            'receive_date'  => $this->request->getPost('receive_date'),
            'approved'      => $status
        ];
        if ($this->model->update($id, $data) === false) {
            return $this->response->setJSON([
                'success'=>false,
                'errorMessages'=>$this->model->errors()]);
        }else{
            $upload=$this->uploadfile->single_upload($id,'loan');
            if($upload['success']===true){
                if(isset($upload['filename'])){
                    $this->model->update($id,['receipn'=>$upload['filename']]);
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
            if(isset($row['receipn'])&&file_exists(FCPATH.'/uploads/employees/loan/'.$row['receipn'])){
                unlink(FCPATH.'/uploads/employees/loan/'.$row['receipn']);
            }
        }
		return $this->response->setJSON(array('success'=>true));
	}
}