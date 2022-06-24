<?php

class Ageingprocess extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

	public function index(){
        $check = $this->model('Home_model')->checkUsermenu('ageingprocess','Read');
        if ($check){
            $data['title'] = 'AGEING PROCESS';
            $data['menu']  = 'AGEING PROCESS';  
  
            $this->view('templates/header_a', $data);
            $this->view('criticalpartprocess/ageing', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }    
    }

	public function checkKepiLot($params){
		$url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $kepi_lot = $params['kepilot'];
		$check = $this->model('Ageingprocess_model')->checkKepiLot($kepi_lot);
		if($check){
			echo json_encode($check);
		}else{
			echo 'false';
		}
	}

	public function checkKepiLotAlreadyProcessed($params){
		$url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $kepi_lot = $params['kepilot'];
		$check = $this->model('Ageingprocess_model')->checkKepiLotAlreadyProcessed($kepi_lot);
		if($check){
			echo json_encode($check);
		}else{
			echo 'false';
		}		
	}

    public function save(){
		$check = $this->model('Home_model')->checkUsermenu('ageingprocess','Create');
		if ($check){
			if( $this->model('Ageingprocess_model')->save($_POST) > 0 ) {
				Flasher::setMessage('Ageing Process Created','','success');
				header('location: '. BASEURL . '/ageingprocess');
				exit;			
			}else{
				Flasher::setMessage('Ageing Process Failed','','danger');
				header('location: '. BASEURL . '/ageingprocess');
				exit;	
			}
        }else{
            $this->view('templates/401');
        }  
    }
}