<?php

class Partlotdisposition extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('partlotdisposition','Read');
        if ($check){
            $data['title'] = 'PART LOT DISPOSITION';
            $data['menu']  = 'PART LOT DISPOSITION';  
  
            // $data['location'] = $this->model('Smtprocess_model')->getLocation();
  
            $this->view('templates/header_a', $data);
            $this->view('criticalpartprocess/partdisposition', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }    
    }

    public function getkepilot($params){
        $url  = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $kepi_lot = $params['kepilot'];
		// $assycode = $params['assycode'];
		$data['agheader'] = $this->model('Partlotdisposition_model')->getKepiAgeingHeader($kepi_lot);
        $data['ftheader'] = $this->model('Partlotdisposition_model')->getKepiFTHeader($kepi_lot);
        $data['details']  = $this->model('Partlotdisposition_model')->getKepiDetails($kepi_lot);
		// if($check['data']){
		echo json_encode($data);
		// }else{
		// 	echo 'false';
		// }
    }

    public function saveUpdate1(){
        if( $this->model('Partlotdisposition_model')->saveUpdate1($_POST) > 0 ) {
            $result = array(
                "msgtype" => "1",
                "message" => "Success"
            );
            echo json_encode($result);
            // echo json_encode($nextNumb['nextnumb']);
            exit;			
        }else{
            // $result = ["msg"=>"error"];
            $result = array(
                "msgtype" => "2",
                "message" => "Error"
            );
            echo json_encode($result);
            exit;	
        }
    }

    public function saveUpdate2(){
        if( $this->model('Partlotdisposition_model')->saveUpdate2($_POST) > 0 ) {
            $result = array(
                "msgtype" => "1",
                "message" => "Success"
            );
            echo json_encode($result);
            // echo json_encode($nextNumb['nextnumb']);
            exit;			
        }else{
            // $result = ["msg"=>"error"];
            $result = array(
                "msgtype" => "2",
                "message" => "Error"
            );
            echo json_encode($result);
            exit;	
        }
    }
}