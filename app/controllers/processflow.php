<?php

class Processflow extends Controller {

    public function __construct(){
        if( isset($_SESSION['usr']) ){
        }else{
            header('location:'. BASEURL);
        }
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('processflow','Read');
        if ($check){
            $data['title'] = 'Transaction Process Flow';
            $data['menu']  = 'Transaction Process Flow';

            $data['rdata']    = $this->model('Processflow_model')->getAll();
            $data['userlist'] = $this->model('User_model')->userList();

            $this->view('templates/header_a', $data);
            $this->view('processflow/index',  $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function save(){
        if( $this->model('Processflow_model')->save($_POST) > 0 ) {
			Flasher::setMessage('Transaction Flow Update','','success');
			header('location: '. BASEURL . '/processflow');
			exit;			
		}else{
			Flasher::setMessage('Update Transaction Flow Fail,','','danger');
			header('location: '. BASEURL . '/processflow');
			exit;	
		}
    }
}