<?php

class Transaction extends Controller {

    public function __construct(){
        if( isset($_SESSION['usr']) ){
        }else{
            header('location:'. BASEURL);
        }
    }

    public function form(){
        $check = $this->model('Home_model')->checkUsermenu('transaction/form','Read');
        if ($check){
            $data['title'] = 'Generate Transaction Form';
            $data['menu']  = 'Generate Transaction Form';

            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();  


            $this->view('templates/header_a', $data);
            $this->view('transaction/form', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function process(){
        $check = $this->model('Home_model')->checkUsermenu('transaction/process','Create');
        if ($check){
            $data['title'] = 'Transaction Process';
            $data['menu']  = 'Transaction Process';

            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();  

            $data['defect']   = $this->model('Defect_model')->getDefectList();
            $data['location'] = $this->model('Location_model')->getLocationList();
            $data['cause']    = $this->model('Cause_model')->getCauseList();
            $data['action']   = $this->model('Action_model')->getActionList();
            $data['process']  = $this->model('Transaction_model')->getProcessSequence('process');

            $this->view('templates/header_a', $data);
            $this->view('transaction/process', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function repair(){
        $check = $this->model('Home_model')->checkUsermenu('transaction/process','Create');
        if ($check){
            $data['title'] = 'Transaction Repair';
            $data['menu']  = 'Transaction Repair';

            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();  

            $data['defect']   = $this->model('Defect_model')->getDefectList();
            $data['location'] = $this->model('Location_model')->getLocationList();
            $data['cause']    = $this->model('Cause_model')->getCauseList();
            $data['action']   = $this->model('Action_model')->getActionList();
            $data['process']  = $this->model('Transaction_model')->getProcessSequence('repair');

            $this->view('templates/header_a', $data);
            $this->view('transaction/repair', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function getserialprocess($params){
        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $serial = $params['serial'];

        $data = $this->model('Transaction_model')->getDataBySerial($serial);
        $data['_lastprocess'] = $this->model('Transaction_model')->getProcessSequenceNumber($data['lastprocess'],'process');
        echo json_encode($data);
    }

    public function getserialrepair($params){
        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $serial = $params['serial'];

        $data = $this->model('Transaction_model')->getDataBySerial($serial);
        $data['_lastrepair'] = $this->model('Transaction_model')->getProcessSequenceNumber($data['lastprocess'],'repair');
        echo json_encode($data);
    }

    public function formsave(){
        if( $this->model('Transaction_model')->saveform($_POST) > 0 ) {
			Flasher::setMessage('Transaction Form Created','','success');
			header('location: '. BASEURL . '/transaction/form');
			exit;			
		}else{
			Flasher::setMessage('Create Transaction Form Fail,','','danger');
			header('location: '. BASEURL . '/transaction/form');
			exit;	
		}
    }

    public function saveprocess(){
        $process  = $this->model('Transaction_model')->getDataTransid($_POST['formid']);
        $sequence = $this->model('Transaction_model')->getProcessSequence('process');
        $checkNG  = $this->model('Transaction_model')->checNGStatus($_POST['formid']);

        if($process['lastprocess'] == $sequence['sequence']){
            // Flasher::setMessage('Serial NO '. $_POST['_lotnumber'] .' already processed in '. $sequence['processname'],'','danger');
			// header('location: '. BASEURL . '/transaction/process');
            $return = array(
                "msgtype" => "2",
                "message" => 'Serial NO '. $_POST['_lotnumber'] .' already processed in '. $sequence['processname']
            );
            echo json_encode($return);
			exit;	
        }else{
            $checkProcess = $sequence['sequence'] - $process['lastprocess'];
            if($checkProcess > 1){
                // Flasher::setMessage('Previous Process In Serial NO '. $_POST['_lotnumber'] .' not processed yet','','danger');
                // header('location: '. BASEURL . '/transaction/process');
                $return = array(
                    "msgtype" => "2",
                    "message" => 'Previous Process In Serial NO '. $_POST['_lotnumber'] .' not processed yet'
                );
                echo json_encode($return);
                exit;
            }else{
                if($checkNG){
                    // Flasher::setMessage('Cannot Process Serial No '. $_POST['lotnumber'] .', Status is NG in Previous Process '. $sequence['processname'],'','danger');
                    // header('location: '. BASEURL . '/transaction/process');
                    $return = array(
                        "msgtype" => "2",
                        "message" => 'Cannot Process Serial No '. $_POST['lotnumber'] .', Status is NG in Previous Process '. $sequence['processname']
                    );
                    echo json_encode($return);
                    exit;
                }else{
                    if( $this->model('Transaction_model')->saveprocess($_POST) > 0 ) {
                        // Flasher::setMessage('Transaction Serial NO '. $_POST['_lotnumber'] .' Processed','','success');
                        // header('location: '. BASEURL . '/transaction/process');
                        $return = array(
                            "msgtype" => "1",
                            "message" => 'Transaction Serial NO '. $_POST['_lotnumber'] .' Processed'
                        );
                        echo json_encode($return);
                        exit;			
                    }else{
                        // Flasher::setMessage('Process Transaction Serial NO '. $_POST['_lotnumber'] .' Fail','','danger');
                        // header('location: '. BASEURL . '/transaction/process');
                        $return = array(
                            "msgtype" => "2",
                            "message" => 'Process Transaction Serial NO '. $_POST['_lotnumber'] .' Fail'
                        );
                        echo json_encode($return);
                        exit;	
                    }
                }
            }
        }
    }

    public function saverepair(){
        $process  = $this->model('Transaction_model')->getRepairDataTransid($_POST['formid']);
        $sequence = $this->model('Transaction_model')->getProcessSequence('repair');
        // echo json_encode($sequence);
        
        if($process['lastrepair'] == null){
            $process['lastrepair'] = 0;
        }

        if($process['lastrepair'] == $sequence['sequence']){
            Flasher::setMessage('Serial NO '. $_POST['_lotnumber'] .' already processed in '. $sequence['processname'],'','danger');
			header('location: '. BASEURL . '/transaction/repair');
			exit;	
        }else{
            $checkProcess = $sequence['sequence'] - $process['lastrepair'];
            if($checkProcess > 1){
                Flasher::setMessage('Previous Process In Serial NO '. $_POST['_lotnumber'] .' not processed yet','','danger');
                header('location: '. BASEURL . '/transaction/repair');
                exit;
            }else{
                if( $this->model('Transaction_model')->saveRepairForm($_POST) > 0 ) {
                    Flasher::setMessage('Transaction Serial NO '. $_POST['_lotnumber'] .' Processed','','success');
                    header('location: '. BASEURL . '/transaction/repair');
                    exit;			
                }else{
                    Flasher::setMessage('Process Transaction Serial NO '. $_POST['_lotnumber'] .' Fail','','danger');
                    header('location: '. BASEURL . '/transaction/repair');
                    exit;	
                }
            }
        }
    }
}