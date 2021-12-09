<?php

class Home extends Controller {

	public function index()
	{
		if( isset($_SESSION['usr']) ){
			$data['title'] = 'Dashboard';
			$data['menu']  = 'Dashboard';

			$this->view('templates/header_a', $data);
			$this->view('dashboard/home', $data);
			$this->view('templates/footer_a',$data);
		}else{
			$data['title'] = 'Login';
			$this->view('home/login', $data);
		}
	}

	public function members(){
		$data['user'] = $this->model('Home_model')->login($_POST);
		if($data['user'] === false){
			header('location: '. BASEURL );
		}else if($data['user'] == 'X'){
			header('location: '. BASEURL );
		}else{
			Auth::setLoginSession($data['user']['username'],$data['user']['password'],'admin',$data['user']['userlevel'],$data['user']['nama'],$data['user']['jbtn'],$data['user']['department'],$data['user']['jabatan']);
			header('location: '. BASEURL );
		}
	}

	public function logout(){
		// setcookie($_SESSION['usr']['user'], "AUTH-USER", time() - 3600); 
		unset($_SESSION['usr']);
		header('location: '. BASEURL);
	}

	public function register(){
		if( $this->model('Home_model')->register($_POST) > 0 ) {
			Flasher::setMessage('Berhasil','','success');
			header('location: '. BASEURL );
			exit;			
		}else if( $this->model('Home_model')->register($_POST) == 'X' ) {
			Flasher::setMessage('Gagal',', User Sudah Terdaftar','danger');
			header('location: '. BASEURL );
			exit;			
		}else{
			Flasher::setMessage('Gagal','','danger');
			header('location: '. BASEURL );
			exit;	
		}
	}
}