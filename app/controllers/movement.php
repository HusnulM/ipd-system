<?php

class Movement extends Controller {

    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('movement','Create');
        if ($check){
            $data['title'] = 'Inventory Movement';
            $data['menu']  = 'Inventory Movement';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------

            $data['invmov']   = $this->model('Movement_model')->getInvMovementByAuth();
            $data['whs']      = $this->model('Warehouse_model')->getWarehouseByAuth();

            $data['whslist'] = json_encode($data['whs']);

            $this->view('templates/header_a', $data);
            $this->view('movement/index', $data);
            $this->view('templates/footer_a');
        }else{
			$this->view('templates/401');
		}
    }

    public function checkporelstat($params){
        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
		$ponum = $params['ponum'];
        $data = $this->model('Po_model')->getPOHeader($ponum);
        echo json_encode($data);
    }

    public function checkauthwhs($whsnum){
        $data = $this->model('Movement_model')->checkwhsauth($whsnum);
        echo json_encode($data);
    }

    public function checkstock($material, $whs, $inputqty){
        $data = $this->model('Movement_model')->checkStockwhs($material, $whs, $inputqty);
        echo json_encode($data);
    }

    public function listpotogr(){
        $data['data'] = $this->model('Movement_model')->getPotoGR();
        echo json_encode($data);
    }

    public function listreservasitotf(){
        $data['data'] = $this->model('Movement_model')->getResrvasitoTF();
        echo json_encode($data);
    }

    public function postlockdata(){

    }

    public function readlockdata($object,$docnum){
        $data = $this->model('Movement_model')->readlockdata($object,$docnum);
        echo json_encode($data);
    }

    public function getopenpoitem(){
        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
		$ponum = $params['ponum'];

		$data = $this->model('Movement_model')->getPOitemtoGR($ponum);
		echo json_encode($data);
    }

    public function reservationitem($resnum){
        $check = $this->model('Home_model')->checkUsermenu('movement', 'Create');
        if ($check){
            $data = $this->model('Reservation_model')->getReservation02($resnum);
            echo json_encode($data);
        }else{
            echo json_encode("unauthorize!");
        }
    }

    public function post(){
        try {
            if($_POST['immvt'] === "101"){
                $data = $this->model('Movement_model')->getPOitemtoGR($_POST['itm_refnum'][0]);
                $lock = $this->model('Movement_model')->readlockdata('PO',$_POST['itm_refnum'][0]);
                if($data[0]['approvestat'] === "2"){
                    if($lock){
                        $return = array(
                            "msgtype" => "3",
                            "message" => "PO ". $_POST['itm_refnum'][0] ." Lock by ". $lock['lockby']
                        );
                        echo json_encode($return);
                        exit;	
                    }else{
                        $nextNumb = $this->model('Home_model')->getNextNumber('GRPO');
                        if( $this->model('Movement_model')->post($_POST, $nextNumb['nextnumb']) > 0 ) {
                            $return = array(
                                "msgtype" => "1",
                                "message" => "Inventory Movement Posted!",
                                "docnum"  => $nextNumb['nextnumb']
                            );
                            echo json_encode($return);
                            exit;			
                        }else{
                            $return = array(
                                "msgtype" => "3",
                                "message" => "Error!",
                                "data"    => Flasher::errorMessage()
                            );
                            $this->model('Movement_model')->delete($nextNumb['nextnumb']);
                            echo json_encode($return);
                            exit;	
                        }
                    }
                }else{
                    $return = array(
                        "msgtype" => "3",
                        "message" => "PO ". $_POST['itm_refnum'][0] ." Not Approved yet or Rejected!"
                    );
                    echo json_encode($return);
                    exit;	
                }
            }else{
                $checkstock = $this->model('Movement_model')->checkinventorystock($_POST);
                if(count($checkstock) > 0){
                    $return = array(
                        "msgtype" => "2",
                        "message" => "Check inventory stock",
                        "data"    => $checkstock
                    );
                    echo json_encode($return);
                }elseif(count($checkstock) == 0){
                    $nextNumb = $this->model('Home_model')->getNextNumber('GRPO');
                    if( $this->model('Movement_model')->post($_POST, $nextNumb['nextnumb']) > 0 ) {
                        $return = array(
                            "msgtype" => "1",
                            "message" => "Inventory Movement Posted!",
                            "docnum"  => $nextNumb['nextnumb']
                        );
                        echo json_encode($return);
                        exit;			
                    }else{
                        $return = array(
                            "msgtype" => "3",
                            "message" => "Error!",
                            "data"    => Flasher::errorMessage()
                        );
                        $this->model('Movement_model')->delete($nextNumb['nextnumb']);
                        echo json_encode($return);
                        exit;	
                    }
                }        
            }
        }catch (Exception $e) {
            $message = 'Caught exception: '.  $e->getMessage(). "\n";
            return $message;
        }
    }
}