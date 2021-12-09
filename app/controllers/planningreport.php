<?php

class Planningreport extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('planningreport','Read');
        if ($check){
            $data['title'] = 'Production Planning Report';
            $data['menu']  = 'Production Planning Report';  

            $data['lines'] = $this->model('Line_model')->getListProductionLines();

            $this->view('templates/header_a', $data);
            $this->view('production/planningreport', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }    
    }

    public function planningreportview($strdate, $enddate, $params){
        $url   = parse_url($_SERVER['REQUEST_URI']);
        $data  = parse_str($url['query'], $params);
        $model = $params['model'];

        // echo json_encode($model);

        $check = $this->model('Home_model')->checkUsermenu('planningreport','Read');
        if ($check){
            $data['title'] = 'Production Planning Report';
            $data['menu']  = 'Production Planning Report';



            $data['rdata'] = $this->model('Production_model')->getPlanningByDate($strdate, $enddate, $model);
            $data['strdate'] = $strdate;
            $data['enddate'] = $enddate;
            $data['model']   = $model;

            $this->view('templates/header_a', $data);
            $this->view('production/planningreportview', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }   
    }
}