<?php

class User extends Controller{

	public function __construct(){
		if( isset($_SESSION['usr']) ){
		}
		else{
			header('location:'. BASEURL);
		}
	}

	public function index(){
		$check = $this->model('Home_model')->checkUsermenu('user','Read');
        if ($check){
			$data['title']    = 'Data User';
			$data['menu']     = 'User';
			$data['menu-dsc'] = 'Maintain User';
			
			 // Wajib di semua route ke view--------------------------------------------
			 $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			 $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			 //-------------------------------------------------------------------------   
	
			 $data['rdata']    = $this->model('User_model')->userList();
	
			$this->view('templates/header_a', $data);
			$this->view('user/index', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
	}

	public function create(){
		$check = $this->model('Home_model')->checkUsermenu('user','Create');
        if ($check){
			$data['title']    = 'Add New User';
			$data['menu']     = 'Add New User';
			
			 // Wajib di semua route ke view--------------------------------------------
			 $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			 $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			 //-------------------------------------------------------------------------   
	
			$data['setting']    = $this->model('Setting_model')->getgensetting();
			// $data['department'] = $this->model('Department_model')->getList();
			// $data['jabatan']    = $this->model('Jabatan_model')->getList();
	
			$this->view('templates/header_a', $data);
			$this->view('user/create', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
	}

	public function register(){
		if( $this->model('User_model')->register($_POST) > 0 ) {
			Flasher::setMessage('User Successfully','Created','success');
			header('location: '. BASEURL .'/user');
			exit;			
		}else if( $this->model('User_model')->register($_POST) == 'X' ) {
			Flasher::setMessage('Error,','User Already Registered','danger');
			header('location: '. BASEURL .'/user/create' );
			exit;			
		}else{
			Flasher::setMessage('Error','Check your input','danger');
			header('location: '. BASEURL .'/user/create');
			exit;	
		}
	}

	public function delete($id){
		$check = $this->model('Home_model')->checkUsermenu('user','Delete');
        if ($check){
			if( $this->model('User_model')->deleteData($id) > 0 ) {
				Flasher::setMessage('User Successfully','Deleted','success');
				header('location: '. BASEURL . '/user');
				exit;			
			}else{
				Flasher::setMessage('Error','Delete Data','danger');
				header('location: '. BASEURL . '/user');
				exit;	
			}
		}else{
			$this->view('templates/401');
		}
	}

	public function changepassword(){
		$data['title'] = 'Edit Password';
		$data['menu'] = 'User';
		$data['menu-dsc'] = 'Change Password';

		// Wajib di semua route ke view--------------------------------------------
		 $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
		 $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
		 //-------------------------------------------------------------------------   

		$this->view('templates/header_a', $data);
		$this->view('user/changepass', $data);
		$this->view('templates/footer_a');
	}

	public function updatepassword(){
		if( $this->model('User_model')->updatePass($_POST) > 0 ) {
			Flasher::setMessage('Password ','Updated','success');
			header('location: '. BASEURL);
			exit;			
		}else{
			Flasher::setMessage('Error','','danger');
			header('location: '. BASEURL);
			exit;	
		}
	}

	public function edit($username){
		$check = $this->model('Home_model')->checkUsermenu('user','Update');
        if ($check){
			$data['title'] = 'Change User';
			$data['menu']  = 'Change User';
	
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   
	
			$data['user']       = $this->model('User_model')->getUserbyid($username);
			
			// echo json_encode($data['user']);
			$this->view('templates/header_a', $data);
			$this->view('user/edit', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
	}

	public function update(){
		if( $this->model('User_model')->updateuser($_POST) > 0 ) {
			Flasher::setMessage('User ','Updated','success');
			header('location: '. BASEURL . '/user');
			exit;			
		}else{
			Flasher::setMessage('Error','Update Data','danger');
			header('location: '. BASEURL . '/user');
			exit;	
		}
	}
}