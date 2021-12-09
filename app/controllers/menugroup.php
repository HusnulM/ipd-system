<?php

class Menugroup extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('menugroup','Read');
        if ($check){
            $data['title'] = 'Menu Groups';
            $data['menu']  = 'Menu Groups';  

            $data['rdata'] = $this->model('Menugroup_model')->getListMenugroups();   

            $this->view('templates/header_a', $data);
            $this->view('menugroup/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('menugroup','Create');
        if ($check){
            $data['title'] = 'Create Menu Group';
            $data['menu']  = 'Create Menu Group';
                   
            $data['menugroups']  = $this->model('Menugroup_model')->getListMenugroups();         

            $this->view('templates/header_a', $data);
            $this->view('menugroup/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function edit($id){
        $check = $this->model('Home_model')->checkUsermenu('menugroup','Update');
        if ($check){
            $data['title'] = 'Edit Application Menu';
            $data['menu']  = 'Edit Application Menu';       

            $data['group']        = $this->model('Menugroup_model')->getMenugroupByid($id);

            $this->view('templates/header_a', $data);
            $this->view('menugroup/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function listmenu(){
        $data['data'] = $this->model('Menugroup_model')->getListMenu();   
        echo json_encode($data);
    }
    
    public function save(){
		if( $this->model('Menugroup_model')->save($_POST) > 0 ) {
			Flasher::setMessage('Menu Group created','','success');
			header('location: '. BASEURL . '/menugroup');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/menugroup');
			exit;	
	    }
    }

    public function update(){
        if( $this->model('Menugroup_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Menu Group updated','','success');
			header('location: '. BASEURL . '/menugroup');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/menugroup');
			exit;	
	    }
    }
    
    public function delete($id){
        $check = $this->model('Home_model')->checkUsermenu('menugroup', 'Delete');
        if ($check){
            if( $this->model('Menugroup_model')->delete($id) > 0 ) {
                Flasher::setMessage('Menu Group deleted','','success');
                header('location: '. BASEURL . '/menugroup');
                exit;			
            }else{
                Flasher::setMessage('Failed,','','danger');
                header('location: '. BASEURL . '/menugroup');
                exit;	
            }
        }else{
            $this->view('templates/401');
        }         
    }
}