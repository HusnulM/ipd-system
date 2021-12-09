<?php

class Menu extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('menu','Read');
        if ($check){
            $data['title'] = 'Application Menu';
            $data['menu']  = 'Application Menu';  

            $data['menus'] = $this->model('Menu_model')->getListMenu();   

            $this->view('templates/header_a', $data);
            $this->view('menu/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('menu','Create');
        if ($check){
            $data['title'] = 'Create Menu';
            $data['menu']  = 'Create Menu';
                   
            $data['menugroups']  = $this->model('Menu_model')->getListMenugroups();         

            $this->view('templates/header_a', $data);
            $this->view('menu/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function edit($id){
        $check = $this->model('Home_model')->checkUsermenu('menu','Update');
        if ($check){
            $data['title'] = 'Edit Application Menu';
            $data['menu']  = 'Edit Application Menu';       

            $data['menus']        = $this->model('Menu_model')->getMenuById($id);
            $data['currentgroup'] = $this->model('Menu_model')->getMenugroupByid($data['menus']['menugroup']);
            $data['menugroups']   = $this->model('Menu_model')->getListMenugroups();  

            $this->view('templates/header_a', $data);
            $this->view('menu/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function listmenu(){
        $data['data'] = $this->model('Menu_model')->getListMenu();   
        echo json_encode($data);
    }
    
    public function save(){
		if( $this->model('Menu_model')->save($_POST) > 0 ) {
			Flasher::setMessage('Application menu created','','success');
			header('location: '. BASEURL . '/menu');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/menu');
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
    
    public function delete($id){
        $check = $this->model('Home_model')->checkUsermenu('menu', 'Delete');
        if ($check){
            
        }else{
            $this->view('templates/401');
        }         
    }
}