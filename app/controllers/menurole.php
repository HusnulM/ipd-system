<?php

class Menurole extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('menurole', 'Read');
        if ($check){
            $data['title'] = 'Assign Menu to Role';
            $data['menu']  = 'Assign Menu to Role';

            $data['data'] = $this->model('Menurole_model')->getListMenuRoleAssignment();   

            $this->view('templates/header_a', $data);
            $this->view('menurole/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('menurole','Create');
        if ($check){
            $data['title'] = 'Create Menu';
            $data['menu']  = 'Create Menu';  

            $data['roles']    = $this->model('Role_model')->getList();   
            $data['menus']    = $this->model('Menu_model')->getListMenu();   

            $this->view('templates/header_a', $data);
            $this->view('menurole/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function edit($id){
        $check = $this->model('Home_model')->checkUsermenu('menurole','Update');
        if ($check){
            $data['title'] = 'Edit Application Menu';
            $data['menu']  = 'Edit Application Menu';       

            $data['menus']    = $this->model('Menu_model')->getMenuById($id);

            $this->view('templates/header_a', $data);
            $this->view('menurole/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function save(){
		if( $this->model('Menurole_model')->save($_POST) > 0 ) {
			Flasher::setMessage('Assignment success!','','success');
			header('location: '. BASEURL . '/menurole');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/menurole');
			exit;	
	    }
    }

    public function getActivity($roleid, $menuid){
        $data = $this->model('Menurole_model')->getMenuActivity($roleid, $menuid);
        echo json_encode($data);
    }

    public function saveactivity(){
        if( $this->model('Menurole_model')->saveActivity($_POST) > 0 ) {
			$result = ["msg"=>"sukses"];
			echo json_encode($result);
			exit;			
		}else{
			$result = ["msg"=>"error"];
			echo json_encode($result);
			exit;	
	    }
    }

    public function update(){
        if( $this->model('Menu_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Application menu updated','','success');
			header('location: '. BASEURL . '/menu');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/menu');
			exit;	
	    }
    }
    
    public function delete($roleid,$menuid){
        $check = $this->model('Home_model')->checkUsermenu('menurole','Delete');
        if ($check){
            if( $this->model('Menurole_model')->delete($roleid,$menuid) > 0 ) {
                Flasher::setMessage('Assignment deleted','','success');
                header('location: '. BASEURL . '/menurole');
                exit;			
            }else{
                Flasher::setMessage('Failed,','','danger');
                header('location: '. BASEURL . '/menurole');
                exit;	
            }
        }else{
            $this->view('templates/401');
        }         
    }
}