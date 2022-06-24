<?php

class Handworkprocess extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

	public function index(){
        $check = $this->model('Home_model')->checkUsermenu('handworkprocess','Read');
        if ($check){
            $data['title'] = 'HANDWORK LINE PROCESS';
            $data['menu']  = 'HANDWORK LINE PROCESS';  
  
            // $data['location'] = $this->model('Smtprocess_model')->getLocation();
  
            $this->view('templates/header_a', $data);
            $this->view('criticalpartprocess/handwork', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }    
    }

    public function save(){
		$check = $this->model('Home_model')->checkUsermenu('handworkprocess','Create');
		if ($check){
			if( $this->model('Handworkprocess_model')->save($_POST) > 0 ) {
				Flasher::setMessage('Handwork Line Process Created','','success');
				header('location: '. BASEURL . '/handworkprocess');
				exit;			
			}else{
				Flasher::setMessage('Handwork Line Process Failed','','danger');
				header('location: '. BASEURL . '/handworkprocess');
				exit;	
			}
        }else{
            $this->view('templates/401');
        }  
    }
}