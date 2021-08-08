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
            $data['process']  = $this->model('Transaction_model')->getProcessSequence();


            $this->view('templates/header_a', $data);
            $this->view('transaction/process', $data);
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
        $sequence = $this->model('Transaction_model')->getProcessSequence();
        $checkNG  = $this->model('Transaction_model')->checNGStatus($_POST['formid']);

        if($process['lastprocess'] == $sequence['sequence']){
            Flasher::setMessage('Form '. $_POST['formid'] .' already processed in '. $sequence['processname'],'','danger');
			header('location: '. BASEURL . '/transaction/process');
			exit;	
        }else{
            $checkProcess = $sequence['sequence'] - $process['lastprocess'];
            if($checkProcess > 1){
                Flasher::setMessage('Previous Process Form '. $_POST['formid'] .' not processed yet','','danger');
                header('location: '. BASEURL . '/transaction/process');
                exit;
            }else{
                if($checkNG){
                    Flasher::setMessage('Cannot Process Serial No '. $_POST['lotnumber'] .', Status is NG in Previous Process '. $sequence['processname'],'','danger');
                    header('location: '. BASEURL . '/transaction/process');
                    exit;
                }else{
                    if( $this->model('Transaction_model')->saveprocess($_POST) > 0 ) {
                        Flasher::setMessage('Transaction Form '. $_POST['formid'] .' Processed','','success');
                        header('location: '. BASEURL . '/transaction/process');
                        exit;			
                    }else{
                        Flasher::setMessage('Process Transaction Form '. $_POST['formid'] .' Fail','','danger');
                        header('location: '. BASEURL . '/transaction/process');
                        exit;	
                    }
                }
            }
        }
    }

    
}