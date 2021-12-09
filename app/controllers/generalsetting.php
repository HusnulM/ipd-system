<?php

class Generalsetting extends Controller{
    public function __construct(){
      if( isset($_SESSION['usr']) ){

      }else{
        header('location:'. BASEURL);
      }
    }

    public function index(){
      $data['title'] = 'General Setting';
      $data['menu']  = 'General Setting';

      // Wajib di semua route ke view--------------------------------------------
      $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
      $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
      //-------------------------------------------------------------------------   

      $data['setting'] = $this->model('Setting_model')->getgensetting();   

      $this->view('templates/header_a', $data);
      $this->view('setting/index', $data);
      $this->view('templates/footer_a');
  }

  public function save(){
    // echo json_encode($_POST);
    if( $this->model('Setting_model')->savepsetting($_POST) > 0 ) {
      Flasher::setMessage('General Setting updated','','success');
      header('location: '. BASEURL . '/generalsetting');
      exit;			
    }else{
      Flasher::setMessage('error,','','danger');
      header('location: '. BASEURL . '/generalsetting');
      exit;	
    }
  }
}