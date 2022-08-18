<?php

class Smtprocess extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('smtprocess','Read');
        if ($check){
            $data['title'] = 'SMT LINE PROCESS';
            $data['menu']  = 'SMT LINE PROCESS';  
  
            // $data['location'] = $this->model('Smtprocess_model')->getLocation();
  
            $this->view('templates/header_a', $data);
            $this->view('criticalpartprocess/smtline', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }    
    }

    public function save(){
        if( $this->model('Smtprocess_model')->save($_POST) > 0 ) {
            Flasher::setMessage('SMT Line Process Created','','success');
            header('location: '. BASEURL . '/smtprocess');
            exit;			
        }else{
            Flasher::setMessage('SMT Line Process Failed','','danger');
            header('location: '. BASEURL . '/smtprocess');
            exit;	
        }
    }

    public function checkkepi($kepi, $assycode){
        $data = $this->model('Smtprocess_model')->checkKepi($kepi, $assycode);
        if($data){
            echo json_encode('1');
        }else{
            echo json_encode('0');
        }
    }

    public function getkepi($kepi){
        $data = $this->model('Smtprocess_model')->getKepi($kepi);
        echo json_encode($data);
    }

    public function getbarcodedetail($params){
        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $barcode = $params['barcode'];

		$data['barcode'] = $this->model('Warehouseissuance_model')->getWareHouseIssuanceByBarcode($barcode);
		if($data['barcode']){
			$data['location'] = $this->model('Partlocation_model')->getLocationByPart($data['barcode']['part_number']);
		}else{
			$data['location'] = null;
		}
		echo json_encode($data);
    }

    public function savesmtline(){
        $data = $this->model('Smtprocess_model')->checkKepi($_POST['kepilot'], $_POST['assycode']);
        if($data){
            $result = array(
                "msgtype" => "2",
                "message" => "KEPI LOT " . $_POST['kepilot'] . " already use in another Assy Code"
            );
            echo json_encode($result);
            exit;	
        }else{
            $checkqr = $this->model('Smtprocess_model')->checkKepiqrcode($_POST['kepilot'], $_POST['barcode']);
            if($checkqr){
                $result = array(
                    "msgtype" => "2",
                    "message" => "KEPI LOT " . $_POST['kepilot'] . " With Barcode ". $_POST['barcode'] ." already processed"
                );
                echo json_encode($result);
                exit;
            }else{
                $checkpartmodel = $this->model('Smtprocess_model')->checkpartmodel($_POST['partnumber'], $_POST['partmodel']);
                if($checkpartmodel){
                    if( $this->model('Smtprocess_model')->save($_POST) > 0 ) {
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
                }else{
                    $result = array(
                        "msgtype" => "2",
                        "message" => "Partnumber does not match with part Model"
                    );
                    echo json_encode($result);
                    exit;	
                }
            }
        }
    }
}