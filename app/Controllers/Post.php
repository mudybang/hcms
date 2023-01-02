<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Post as PostModel;

class Post extends ResourceController{
    protected $model;
    public function __construct(){
        $this->model = new PostModel();
        $this->pager = \Config\Services::pager();
    }
    public function index(){
        $pager = \Config\Services::pager();
        $data = array(
            'data' =>  $this->model->paginate(10, 'number'),
            'pager' =>  $this->model->pager
        );
        return view('post/post_view', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        return view('post/post_new');
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //load helper form and URL
        helper(['form', 'url']);
         
        //define validation
        $validation = $this->validate([
            'title' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Masukkan Judul Post.'
                ]
            ],
            'content'    => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Masukkan konten Post.'
                ]
            ],
        ]);

        if(!$validation) {

            //render view with error validation message
            return view('post/post_new', [
                'validation' => $this->validator
            ]);

        } else {
            //insert data into database
            $this->model->insert([
                'title'   => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
            ]);

            //flash message
            session()->setFlashdata('message', 'Data Berhasil Disimpan');

            return redirect()->to(base_url('post'));
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $data = array(
            'edit' => $this->model->find($id)
        );

        return view('post/post_edit', $data);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $validation = $this->validate([
            'title' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Masukkan Judul Post.'
                ]
            ],
            'content'    => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Masukkan konten Post.'
                ]
            ],
        ]);
        if(!$validation) {
            return view('post-edit', [
                'edit' => $this->model->find($id),
                'validation' => $this->validator
            ]);

        } else {
            $this->model->update($id, [
                'title'   => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
            ]);
            session()->setFlashdata('message', 'Data Berhasil Diupdate');
            return redirect()->to(base_url('post'));
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $row = $this->model->find($id);
        if($row) {
            $this->model->delete($id);
            session()->setFlashdata('message', 'Data Berhasil Dihapus');
            return redirect()->to(base_url('post'));
        }
    }
}
