<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Role as RoleModel;

class Role extends BaseController{
    protected $model;
    public function __construct(){
        $this->model = new RoleModel();
    }
    public function index(){
        return view('role_view',[
            'user'=>auth()->user()
        ]);
    }
    
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null){
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new(){
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create(){
        if ($this->model->insert($this->request->getPost())) {
            return $this->respondCreated();
        }

        return $this->fail($this->model->errors());
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null){
        if ($found = $this->model->find($id)) {
            return $this->respond(['data' => $found]);
        }

        return $this->fail('Failed');
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null){
        if ($this->model->update($id, $this->request->getRawInput())) {
            return $this->respondCreated();
        }

        return $this->fail($this->model->errors());
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null){
        if ($found = $this->model->delete($id)) {
            return $this->respondDeleted($found);
        }

        return $this->fail('Fail deleted');
    }
}
