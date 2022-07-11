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

    public function getLotByKepi($params){
		$url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $kepi_lot = $params['kepilot'];
		$check['data'] = $this->model('Ftprocess_model')->getPartLotList($kepi_lot);
		if($check['data']){
			echo json_encode($check);
		}else{
			echo 'false';
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

    public function savesft(){
        if( $this->model('Ftprocess_model')->save($_POST) > 0 ) {
            $result = array(
                "msgtype" => "1",
                "message" => "Success"
            );
            echo json_encode($result);
            // Flasher::setMessage('Ageing Process Created','','success');
            exit;			
        }else{
            // $result = ["msg"=>"error"];
            $result = array(
                "msgtype" => "2",
                "message" => "Error"
            );
            echo json_encode($result);
			// Flasher::setMessage('Ageing Process Failed','','danger');
            exit;	
        }
    }
}