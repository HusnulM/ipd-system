<?php

class Rwarehouseissuance extends Controller{

	public function __construct(){
		if( isset($_SESSION['usr']) ){
			
		}else{
			header('location:'. BASEURL);
		}
    }

	public function index(){
		$check = $this->model('Home_model')->checkUsermenu('rwarehouseissuance','Read');
        if ($check){
			$data['title']    = 'Report Warehouse Issuance';
			$data['menu']     = 'Report Warehouse Issuance';

			$this->view('templates/header_a', $data);
			$this->view('reports/whissuance', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }   
	}

    public function detailview($strdate, $enddate){
		$check = $this->model('Home_model')->checkUsermenu('rwarehouseissuance','Read');
        if ($check){
			$data['title']    = 'Report Warehouse Issuance';
			$data['menu']     = 'Report Warehouse Issuance';

			$data['rdata']   = $this->model('Rwarehouseissuance_model')->getReportData($strdate, $enddate);
			$data['strdate'] = $strdate;
			$data['enddate'] = $enddate;

			$this->view('templates/header_a', $data);
			$this->view('reports/whissuanceview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }          
    }
}