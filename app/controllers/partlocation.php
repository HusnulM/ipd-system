<?php

class Partlocation extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
      $check = $this->model('Home_model')->checkUsermenu('partlocation','Read');
      if ($check){
          $data['title'] = 'PART CODE LOCATION';
          $data['menu']  = 'PART CODE LOCATION';  

          $data['location'] = $this->model('Partlocation_model')->getLocation();

          $this->view('templates/header_a', $data);
          $this->view('partlocation/index', $data);
          $this->view('templates/footer_a');
      }else{
          $this->view('templates/401');
      }    
    }

    public function create(){
      $check = $this->model('Home_model')->checkUsermenu('partlocation','Create');
      if ($check){
          $data['title'] = 'ADD PART CODE LOCATION';
          $data['menu']  = 'ADD PART CODE LOCATION';  

          // $data['location'] = $this->model('Partlocation_model')->getLocation();

          $this->view('templates/header_a', $data);
          $this->view('partlocation/create', $data);
          $this->view('templates/footer_a');
      }else{
          $this->view('templates/401');
      }    
    }

    public function edit($uniq_id){
      $check = $this->model('Home_model')->checkUsermenu('partlocation','Create');
      if ($check){
          $data['title'] = 'CHANGE PART CODE LOCATION';
          $data['menu']  = 'CHANGE PART CODE LOCATION';  

          $data['location'] = $this->model('Partlocation_model')->getLocationById($uniq_id);

          $this->view('templates/header_a', $data);
          $this->view('partlocation/edit', $data);
          $this->view('templates/footer_a');
      }else{
          $this->view('templates/401');
      }    
    }

    public function getMaterialbyCode($params){
      $url = parse_url($_SERVER['REQUEST_URI']);
      $data = parse_str($url['query'], $params);
      $material = $params['material'];

      // $data['mat'] = $this->model('Material_model')->getBarangByKode($material);
      $data['loc'] = $this->model('Partlocation_model')->getLocationByPart($material);

      echo json_encode($data);
    }

    public function save(){
      if( $this->model('Partlocation_model')->save($_POST) > 0 ) {
          Flasher::setMessage('PART CODE LOCATION CREATED','','success');
          header('location: '. BASEURL . '/partlocation');
          exit;			
        }else{
          Flasher::setMessage('FAILED CREATE PART CODE LOCATION,','','danger');
          header('location: '. BASEURL . '/partlocation');
          exit;	
        }
    }

    public function update(){
      if( $this->model('Partlocation_model')->update($_POST) > 0 ) {
          Flasher::setMessage('ASSY CODE LOCATION UPDATED','','success');
          header('location: '. BASEURL . '/partlocation');
          exit;			
        }else{
          Flasher::setMessage('FAILED UPDATE ASSY CODE LOCATION,','','danger');
          header('location: '. BASEURL . '/partlocation');
          exit;	
        }
    }

    public function delete($uniq_id){
      if( $this->model('Partlocation_model')->delete($uniq_id) > 0 ) {
          Flasher::setMessage('ASSY CODE LOCATION DELETED','','success');
          header('location: '. BASEURL . '/partlocation');
          exit;			
        }else{
          Flasher::setMessage('FAILED DELETE ASSY CODE LOCATION,','','danger');
          header('location: '. BASEURL . '/partlocation');
          exit;	
        }
    }
}