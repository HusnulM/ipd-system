<?php

class Partscontrol extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
      $check = $this->model('Home_model')->checkUsermenu('partscontrol','Read');
      if ($check){
          $data['title'] = 'WAREHOUSE ISSUANCE';
          $data['menu']  = 'WAREHOUSE ISSUANCE';  

          $data['lines'] = $this->model('Line_model')->getListProductionLines();

          $this->view('templates/header_a', $data);
          $this->view('partscontrol/index', $data);
          $this->view('templates/footer_a');
      }else{
          $this->view('templates/401');
      }    
    }
}