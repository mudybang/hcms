<?php

namespace App\Controllers;

class Home extends BaseController{
    protected $db;
    public function __construct(){
        $this->db = db_connect();
    }
    public function index(){
        if (auth()->loggedIn()) {
            $data['parent'] = '.';
            $data['title'] = 'Home';
            $data['db'] = $this->db;
            //$data['perm'] = $this->perm->getPerm($this->module_id);
            return view("dashboard",$data);
        }else{
            return redirect()->to('login');
        }
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->to('/login');
    }
    public function info()
    {
        phpinfo();
    }
    public function testdb()
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM roles');

        foreach ($query->getResult() as $row) {
            echo $row->id;
            echo $row->name;
        }
    }
}
