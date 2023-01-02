<?php

namespace Company\Company\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserPerm;
use App\Libraries\PlatformDetect;
use App\Libraries\UploadFile;
use Company\Company\Models\MCompany;

class Profile extends BaseController{
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
        $this->table        = 'companies';
        $this->model        = new MCompany;
        $this->module_id    = 48;
        $this->modules      = $this->perm->getModule($this->module_id);
        $this->uploadfile   = new UploadFile;
    }
    public function index($company_id=0){
        if (auth()->loggedIn()) {
            $data['parent'] = $this->modules['menu_label'];
            $data['title'] = 'Profile';
            $data['db'] = $this->db;
            $data['perm'] = $this->perm->getPerm($this->module_id);
            $data['isMobile']=$this->request->getUserAgent()->isMobile();
            $data['company_id']=$company_id;
            $data['edit']=$this->model->getWhere(['id'=>$company_id])->getRowArray();
            return view("\Company\Company\Views\profile",$data);
        }else{
            return redirect()->to('login');
        }
	}
    public function update($company_id=0){
        $data=[
            'name'        => $this->request->getPost('name'),
            'address'     => $this->request->getPost('address'),
            'phone'       => $this->request->getPost('phone')
        ];
		if($this->model->update($company_id,$data)){
            $upload=$this->uploadfile->single_upload($company_id,'logo','companies');
            if($upload['success']===true){
                if(isset($upload['filename'])){
                    $this->model->update($company_id,['img_logo'=>$upload['filename']]);
                }
            }else{
                session()->setFlashdata('errorMessages', $upload['errorMessage']);
            }           
            return redirect()->to(base_url('company/profile/'.$company_id));
        }
        session()->setFlashdata('errorMessages', ['Update Failed']);
        return redirect()->to(base_url('company/profile/'.$company_id));
    }
}