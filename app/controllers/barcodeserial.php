<?php

class Barcodeserial extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

	public function index(){
		$check = $this->model('Home_model')->checkUsermenu('barcodeserial','Read');
		if ($check){
			$data['title'] = 'BARCODE SERIAL';
			$data['menu']  = 'BARCODE SERIAL';  

			// $data['barcodeserial'] = $this->model('Barcodeserial_model')->getBarcodeSerial();

			$this->view('templates/header_a', $data);
			$this->view('barcodeserial/index', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		} 
	}

	public function create(){
		$check = $this->model('Home_model')->checkUsermenu('barcodeserial','Create');
		if ($check){
			$data['title'] = 'CREATE BARCODE SERIAL';
			$data['menu']  = 'CREATE BARCODE SERIAL';  

			// $data['barcodeserial'] = $this->model('Barcodeserial_model')->getBarcodeSerial();

			$this->view('templates/header_a', $data);
			$this->view('barcodeserial/create', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		} 
	}

	public function edit($barcode){
		$check = $this->model('Home_model')->checkUsermenu('barcodeserial','Update');
		if ($check){
			$data['title'] = 'EDIT BARCODE SERIAL';
			$data['menu']  = 'EDIT BARCODE SERIAL';  

			$data['barcodeserial'] = $this->model('Barcodeserial_model')->getBarcodeDetails($barcode);

			if($data['barcodeserial']){
				$this->view('templates/header_a', $data);
				$this->view('barcodeserial/edit', $data);
				$this->view('templates/footer_a');
			}else{
				Flasher::setMessage('Barcode Not Found!','','error');
				header('location: '. BASEURL . '/barcodeserial');
				exit;
			}
		}else{
			$this->view('templates/401');
		} 
	}

	public function upload(){
		$check = $this->model('Home_model')->checkUsermenu('barcodeserial','Create');
		if ($check){
			$data['title'] = 'UPLOAD BARCODE SERIAL';
			$data['menu']  = 'UPLOAD BARCODE SERIAL';  

			$this->view('templates/header_a', $data);
			$this->view('barcodeserial/upload', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		} 
	}

	public function barcodelist(){
		$data = $this->model('Barcodeserial_model')->getBarcodeSerial();

		echo json_encode($data);
	}

	public function saveUpload(){
		$this->model('Barcodeserial_model')->uploadBarcodeSerial($_POST);
        Flasher::setMessage('Barcode Serial Uploaded!','','success');
		header('location: '. BASEURL . '/barcodeserial');
        exit;
	}
}