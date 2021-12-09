<?php

class Setting extends Controller {

    public function __construct(){
		if( isset($_SESSION['usr']) ){
			if($_SESSION['usr']['userlevel'] === 'Admin'){
				
			}else{
				header('location:'. BASEURL);
			}
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        if( isset($_SESSION['usr']) ){
			$data['title'] = 'General Setting';
			$data['menu'] = 'Setting';
            $data['menu-dsc'] = '';
            $data['setting'] = $this->model('Setting_model')->getgensetting();

			$this->view('templates/header_a', $data);
			$this->view('setting/index', $data);
			$this->view('templates/footer_a');
		}else{
			header('location: '. BASEURL);
		}
	}
	
	public function savesetting(){
		if( $this->model('Setting_model')->savepsetting($_POST) > 0 ) {
			Flasher::setMessage('General Setting ','Saved','success');
			header('location: '. BASEURL . '/setting');
			exit;			
		}else{
			Flasher::setMessage('Error','','danger');
			header('location: '. BASEURL . '/setting');
			exit;	
		}
	}
}