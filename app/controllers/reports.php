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
}