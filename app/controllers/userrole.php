<?php

class Userrole extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('userrole','Read');
        if ($check){
            $data['title'] = 'userrole';
            $data['menu']  = 'userrole';   

            $data['urole'] = $this->model('Userrole_model')->getListUserRoleAssignment();   

            $this->view('templates/header_a', $data);
            $this->view('userrole/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('userrole','Create');
        if ($check){
            $data['title'] = 'Create userrole';
            $data['menu']  = 'Create userrole';      
            
            $data['roles']   = $this->model('Role_model')->getList();   
            $data['user']    = $this->model('User_model')->userList();

            $this->view('templates/header_a', $data);
            $this->view('userrole/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function edit($id){
        $check = $this->model('Home_model')->checkUsermenu('userrole','Update');
        if ($check){
            $data['title'] = 'Edit userrole';
            $data['menu']  = 'Edit userrole';       

            $data['menus']    = $this->model('Userrole_model')->getMenuById($id);

            $this->view('templates/header_a', $data);
            $this->view('userrole/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function save(){
        // echo json_encode($_POST);
		if( $this->model('Userrole_model')->save($_POST) > 0 ) {
			Flasher::setMessage('userrole created','','success');
			header('location: '. BASEURL . '/userrole');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/userrole');
			exit;	
	    }
    }

    public function update(){
        if( $this->model('Userrole_model')->update($_POST) > 0 ) {
			Flasher::setMessage('userrole updated','','success');
			header('location: '. BASEURL . '/userrole');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/userrole');
			exit;	
	    }
    }
    
    public function delete($role,$user){
        $check = $this->model('Home_model')->checkUsermenu('userrole', 'Delete');
        if ($check){
            if( $this->model('Userrole_model')->delete($role,$user) > 0 ) {
                Flasher::setMessage('userrole updated','','success');
                header('location: '. BASEURL . '/userrole');
                exit;			
            }else{
                Flasher::setMessage('Failed,','','danger');
                header('location: '. BASEURL . '/userrole');
                exit;	
            }
        }else{
            $this->view('templates/401');
        }         
    }
}