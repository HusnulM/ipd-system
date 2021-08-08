<?php

class Warehouse extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('warehouse','Read');
        if ($check){
            $data['title'] = 'Warehouse';
            $data['menu']  = 'Warehouse';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['whs'] = $this->model('Warehouse_model')->getList();   

            $this->view('templates/header_a', $data);
            $this->view('warehouse/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('warehouse','Create');
        if ($check){
            $data['title'] = 'Create Warehouse';
            $data['menu']  = 'Create Warehouse';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         

            $this->view('templates/header_a', $data);
            $this->view('warehouse/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function edit($id){
        $check = $this->model('Home_model')->checkUsermenu('warehouse','Update');
        if ($check){
            $data['title'] = 'Edit Warehouse';
            $data['menu']  = 'Edit Warehouse';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         

            $data['whs']      = $this->model('Warehouse_model')->getById($id);

            $this->view('templates/header_a', $data);
            $this->view('warehouse/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function save(){
		if( $this->model('Warehouse_model')->save($_POST) > 0 ) {
			Flasher::setMessage('Warehouse created','','success');
			header('location: '. BASEURL . '/warehouse');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/warehouse');
			exit;	
	    }
    }

    public function update(){
        if( $this->model('Warehouse_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Warehouse updated','','success');
			header('location: '. BASEURL . '/warehouse');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/warehouse');
			exit;	
	    }
    }
    
    public function delete($id){
        $check = $this->model('Home_model')->checkUsermenu('warehouse', 'Delete');
        if ($check){
            if( $this->model('Warehouse_model')->delete($id) > 0 ) {
                Flasher::setMessage('Warehouse deleted','','success');
                header('location: '. BASEURL . '/warehouse');
                exit;			
            }else{
                Flasher::setMessage('Failed,','','danger');
                header('location: '. BASEURL . '/warehouse');
                exit;	
            }
        }else{
            $this->view('templates/401');
        }         
    }

    public function listwarehouse(){
        $data = $this->model('Warehouse_model')->getWarehouseByAuth();   
        echo json_encode($data);
    }
}