<?php

class Production extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('production','Create');
        if ($check){
            $data['title'] = 'Input Production Planning';
            $data['menu']  = 'Input Production Planning';  

            $data['lines'] = $this->model('Line_model')->getListProductionLines();   

            $this->view('templates/header_a', $data);
            $this->view('production/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function inputactualqty(){
        $check = $this->model('Home_model')->checkUsermenu('production/inputactualqty','Create');
        if ($check){
            $data['title'] = 'Input Actual Production Quantity';
            $data['menu']  = 'Input Actual Production Quantity';

            $data['lines'] = $this->model('Line_model')->getListProductionLines();   

            $this->view('templates/header_a', $data);
            $this->view('production/inputActual', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }
    
    public function save(){
        // echo json_encode($_POST);
        // $this->model('Production_model')->savePlanning($_POST);
		if( $this->model('Production_model')->savePlanning($_POST) > 0 ) {
			Flasher::setMessage('Planning Created','','success');
			header('location: '. BASEURL . '/production');
			exit;			
		}else{
			Flasher::setMessage('Failed,','','danger');
			header('location: '. BASEURL . '/production');
			exit;	
	    }
    }

    public function getplanning(){
        $data = $this->model('Production_model')->getPlanningData($_POST);
        echo json_encode($data);
    }

    public function getactualdata(){
        $data = $this->model('Production_model')->getActualData($_POST);
        echo json_encode($data);
    }

    public function productionview(){
        // 
        // echo json_encode($data);
            $data['title'] = 'Production View';
            $data['menu']  = 'Production View';

            $data['rdata'] = $this->model('Production_model')->planningMonitoring();
            $data['hdata'] = $this->model('Production_model')->planningMonitoringDate();

            $this->view('templates/header_a', $data);
            $this->view('production/productionview', $data);
            $this->view('templates/footer_a');
    }

    public function saveactualdata(){
        if( $this->model('Production_model')->saveactualdata($_POST) > 0 ) {
			$return = array(
                "msgtype" => "1",
                "message" => "Actual Quantity Inserted"
            );
            echo json_encode($return);
			exit;			
		}else{
			$return = array(
                "msgtype" => "2",
                "message" => "Insert Actual Quantity Failed"
            );
            echo json_encode($return);
			exit;	
	    }
    }

    public function searchMaterial(){
        $url    = parse_url($_SERVER['REQUEST_URI']);
        $search = $url['query'];
        $search = str_replace("searchName=","",$search);

        $result['data'] = $this->model('Production_model')->searchMaterial($search);
        echo json_encode($result);
    }
}