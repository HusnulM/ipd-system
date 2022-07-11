<?php

class Qainspection extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

	public function index(){
        $check = $this->model('Home_model')->checkUsermenu('qainspection','Read');
        if ($check){
            $data['title'] = 'QA INSPECTION';
            $data['menu']  = 'QA INSPECTION';  
  
            // $data['location'] = $this->model('Smtprocess_model')->getLocation();
  
            $this->view('templates/header_a', $data);
            $this->view('criticalpartprocess/qainspection', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }    
    }

    public function save(){
        if( $this->model('Qainspection_model')->save($_POST) > 0 ) {
            Flasher::setMessage('QA Inspection Created','','success');
            header('location: '. BASEURL . '/qainspection');
            exit;			
        }else{
            Flasher::setMessage('QA Inspection Failed','','danger');
            header('location: '. BASEURL . '/qainspection');
            exit;	
        }
    }

    public function saveqa(){
        if( $this->model('Qainspection_model')->save($_POST) > 0 ) {
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