<?php

class Productionlines extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('productionlines','Read');
        if ($check){
            $data['title'] = 'Production Lines';
            $data['menu']  = 'Production Lines';  

            $data['rdata'] = $this->model('Line_model')->getListProductionLines();   

            $this->view('templates/header_a', $data);
            $this->view('productionlines/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('productionlines','Create');
        if ($check){
            $data['title'] = 'Create Production Line';
            $data['menu']  = 'Create Production Line';   

            $this->view('templates/header_a', $data);
            $this->view('productionlines/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function edit($id){
        $check = $this->model('Home_model')->checkUsermenu('productionlines','Update');
        if ($check){
            $data['title'] = 'Edit Production Line';
            $data['menu']  = 'Edit Production Line';       

            $data['rdata']        = $this->model('Line_model')->getListProductionLinesById($id);

            $this->view('templates/header_a', $data);
            $this->view('productionlines/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }
    
    public function save(){
		if( $this->model('Line_model')->save($_POST) > 0 ) {
			Flasher::setMessage('New Production Line created','','success');
			header('location: '. BASEURL . '/productionlines');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/productionlines');
			exit;	
	    }
    }

    public function update(){
        if( $this->model('Line_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Production line updated','','success');
			header('location: '. BASEURL . '/productionlines');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/productionlines');
			exit;	
	    }
    }
    
    public function delete($id){
        $check = $this->model('Home_model')->checkUsermenu('productionlines', 'Delete');
        if ($check){
            if( $this->model('Line_model')->delete($id) > 0 ) {
                Flasher::setMessage('Production line deleted','','success');
                header('location: '. BASEURL . '/productionlines');
                exit;			
            }else{
                Flasher::setMessage('Failed,','','danger');
                header('location: '. BASEURL . '/productionlines');
                exit;	
            }
        }else{
            $this->view('templates/401');
        }         
    }


    public function searchMaterial(){
        $url    = parse_url($_SERVER['REQUEST_URI']);
        $search = $url['query'];
        $search = str_replace("searchName=","",$search);

        $result['data'] = $this->model('Production_model')->searchMaterial($search);
        echo json_encode($result);
        // echo json_encode($search);
        // echo json_encode($_GET['searchName']);
    }
}