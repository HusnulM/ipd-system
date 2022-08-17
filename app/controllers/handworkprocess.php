<?php

class Handworkprocess extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

	public function index(){
        $check = $this->model('Home_model')->checkUsermenu('handworkprocess','Read');
        if ($check){
            $data['title'] = 'HANDWORK LINE PROCESS';
            $data['menu']  = 'HANDWORK LINE PROCESS';  
  
            // $data['location'] = $this->model('Smtprocess_model')->getLocation();
  
            $this->view('templates/header_a', $data);
            $this->view('criticalpartprocess/handwork', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }    
    }

    public function save(){
		$check = $this->model('Home_model')->checkUsermenu('handworkprocess','Create');
		if ($check){
			if( $this->model('Handworkprocess_model')->save($_POST) > 0 ) {
				Flasher::setMessage('Handwork Line Process Created','','success');
				header('location: '. BASEURL . '/handworkprocess');
				exit;			
			}else{
				Flasher::setMessage('Handwork Line Process Failed','','danger');
				header('location: '. BASEURL . '/handworkprocess');
				exit;	
			}
        }else{
            $this->view('templates/401');
        }  
    }

    public function checkkepi($kepi, $assycode){
        $data = $this->model('Handworkprocess_model')->checkKepi($kepi, $assycode);
        if($data){
            echo json_encode('1');
        }else{
            echo json_encode('0');
        }
    }

    public function getkepi($kepi){
        $data = $this->model('Handworkprocess_model')->getKepi($kepi);
        echo json_encode($data);
    }

    public function saveshandwork(){
        $data = $this->model('Handworkprocess_model')->checkKepi($_POST['kepilot'], $_POST['assycode']);
        if($data){
            $result = array(
                "msgtype" => "2",
                "message" => "KEPI LOT " . $_POST['kepilot'] . " already use in another Assy Code"
            );
            echo json_encode($result);
            exit;	
        }else{
            $checkqr = $this->model('Handworkprocess_model')->checkKepiqrcode($_POST['kepilot'], $_POST['barcode']);
            if($checkqr){
                $result = array(
                    "msgtype" => "2",
                    "message" => "KEPI LOT " . $_POST['kepilot'] . " With Barcode ". $_POST['barcode'] ." already processed"
                );
                echo json_encode($result);
                exit;
            }else{
                $checkpartmodel = $this->model('Smtprocess_model')->checkpartmodel($_POST['kepilot'], $_POST['barcode']);
                if($checkpartmodel){
                    if( $this->model('Handworkprocess_model')->save($_POST) > 0 ) {
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