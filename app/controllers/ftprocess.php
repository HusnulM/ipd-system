<?php

class Ftprocess extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

	public function index(){
        $check = $this->model('Home_model')->checkUsermenu('ftprocess','Read');
        if ($check){
            $data['title'] = 'FT PROCESS';
            $data['menu']  = 'FT PROCESS';  
  
            // $data['location'] = $this->model('Smtprocess_model')->getLocation();
  
            $this->view('templates/header_a', $data);
            $this->view('criticalpartprocess/ftprocess', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }    
    }

    public function save(){
        if( $this->model('Ftprocess_model')->save($_POST) > 0 ) {
            Flasher::setMessage('FT Process Created','','success');
            header('location: '. BASEURL . '/ftprocess');
            exit;			
        }else{
            Flasher::setMessage('FT Process Failed','','danger');
            header('location: '. BASEURL . '/ftprocess');
            exit;	
        }
    }
}