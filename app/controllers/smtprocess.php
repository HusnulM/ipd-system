<?php

class Smtprocess extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('smtprocess','Read');
        if ($check){
            $data['title'] = 'SMT LINE PROCESS';
            $data['menu']  = 'SMT LINE PROCESS';  
  
            // $data['location'] = $this->model('Smtprocess_model')->getLocation();
  
            $this->view('templates/header_a', $data);
            $this->view('criticalpartprocess/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }    
    }

    public function save(){
        if( $this->model('Smtprocess_model')->save($_POST) > 0 ) {
            Flasher::setMessage('SMT Line Process Created','','success');
            header('location: '. BASEURL . '/smtprocess');
            exit;			
        }else{
            Flasher::setMessage('SMT Line Process Failed','','danger');
            header('location: '. BASEURL . '/smtprocess');
            exit;	
        }
    }
}