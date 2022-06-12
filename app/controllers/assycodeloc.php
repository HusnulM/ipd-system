<?php

class Assycodeloc extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
      $check = $this->model('Home_model')->checkUsermenu('assycodeloc','Read');
      if ($check){
          $data['title'] = 'ASSY CODE LOCATION';
          $data['menu']  = 'ASSY CODE LOCATION';  

          $data['location'] = $this->model('Assycodeloc_model')->getLocation();

          $this->view('templates/header_a', $data);
          $this->view('assycodeloc/index', $data);
          $this->view('templates/footer_a');
      }else{
          $this->view('templates/401');
      }    
    }

    public function create(){
      $check = $this->model('Home_model')->checkUsermenu('assycodeloc','Create');
      if ($check){
          $data['title'] = 'ADD ASSY CODE LOCATION';
          $data['menu']  = 'ADD ASSY CODE LOCATION';  

          // $data['location'] = $this->model('Assycodeloc_model')->getLocation();

          $this->view('templates/header_a', $data);
          $this->view('assycodeloc/create', $data);
          $this->view('templates/footer_a');
      }else{
          $this->view('templates/401');
      }    
    }

    public function edit($uniq_id){
      $check = $this->model('Home_model')->checkUsermenu('assycodeloc','Create');
      if ($check){
          $data['title'] = 'CHANGE ASSY CODE LOCATION';
          $data['menu']  = 'CHANGE ASSY CODE LOCATION';  

          $data['location'] = $this->model('Assycodeloc_model')->getLocationById($uniq_id);

          $this->view('templates/header_a', $data);
          $this->view('assycodeloc/edit', $data);
          $this->view('templates/footer_a');
      }else{
          $this->view('templates/401');
      }    
    }

    public function save(){
      if( $this->model('Assycodeloc_model')->save($_POST) > 0 ) {
          Flasher::setMessage('ASSY CODE LOCATION CREATED','','success');
          header('location: '. BASEURL . '/assycodeloc');
          exit;			
        }else{
          Flasher::setMessage('FAILED CREATE ASSY CODE LOCATION,','','danger');
          header('location: '. BASEURL . '/assycodeloc');
          exit;	
        }
    }

    public function update(){
      if( $this->model('Assycodeloc_model')->update($_POST) > 0 ) {
          Flasher::setMessage('ASSY CODE LOCATION UPDATED','','success');
          header('location: '. BASEURL . '/assycodeloc');
          exit;			
        }else{
          Flasher::setMessage('FAILED UPDATE ASSY CODE LOCATION,','','danger');
          header('location: '. BASEURL . '/assycodeloc');
          exit;	
        }
    }

    public function delete($uniq_id){
      if( $this->model('Assycodeloc_model')->delete($uniq_id) > 0 ) {
          Flasher::setMessage('ASSY CODE LOCATION DELETED','','success');
          header('location: '. BASEURL . '/assycodeloc');
          exit;			
        }else{
          Flasher::setMessage('FAILED DELETE ASSY CODE LOCATION,','','danger');
          header('location: '. BASEURL . '/assycodeloc');
          exit;	
        }
    }
}