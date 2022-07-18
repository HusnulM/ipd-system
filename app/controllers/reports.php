<?php

class Reports extends Controller{

	public function __construct(){
		if( isset($_SESSION['usr']) ){
			
		}else{
			header('location:'. BASEURL);
		}
    }

	public function index(){
		header('location:'. BASEURL);
	}

    public function transaction(){
		$check = $this->model('Home_model')->checkUsermenu('reports/transaction','Read');
        if ($check){
			$data['title']    = 'Report Transaction Process';
			$data['menu']     = 'Report Transaction Process';

			$this->view('templates/header_a', $data);
			$this->view('reports/transaction', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }          
    }

    public function transactionview($strdate, $enddate){
		$check = $this->model('Home_model')->checkUsermenu('reports/transaction','Read');
        if ($check){
			$data['title']    = 'Report Transaction Process';
			$data['menu']     = 'Report Transaction Process';

			$data['rdata']   = $this->model('Report_model')->rtransaction($strdate, $enddate);
			$data['strdate'] = $strdate;
			$data['enddate'] = $enddate;

			$this->view('templates/header_a', $data);
			$this->view('reports/transactionview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }          
    }

	public function criticalpart(){
		$check = $this->model('Home_model')->checkUsermenu('reports/criticalpart','Read');
        if ($check){
			$data['title']    = 'Report Critical Parts';
			$data['menu']     = 'Report Critical Parts';

			$this->view('templates/header_a', $data);
			$this->view('reports/criticalpart', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }          
    }

    public function criticalpartview($strdate = null, $enddate = null){
		$check = $this->model('Home_model')->checkUsermenu('reports/criticalpart','Read');
        if ($check){
			$data['title']    = 'Report Critical Parts';
			$data['menu']     = 'Report Critical Parts';

			$data['rdata']   = $this->model('Report_model')->rcriticalpart($strdate, $enddate);
			// $data['rdatadtl']= $this->model('Report_model')->rcriticalpartdetails($strdate, $enddate);
			$data['strdate'] = $strdate;
			$data['enddate'] = $enddate;

			// echo json_encode($data);
			$this->view('templates/header_a', $data);
			$this->view('reports/criticalpartview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }          
    }
}