<?php

class Department extends Controller{
    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }
    
    public function index(){
		$check = $this->model('Home_model')->checkUsermenu('department','Read');
        if ($check){
			$data['title'] = 'Master department';
			$data['menu']  = 'Master department';
			$data['menu-dsc'] = '';
	
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   
	
			$data['department'] = $this->model('Department_model')->getList();
	
			$this->view('templates/header_a', $data);
			$this->view('department/index', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
    }

    public function create(){
		$check = $this->model('Home_model')->checkUsermenu('department','Create');
        if ($check){
			$data['title'] = 'Create department';
			$data['menu']  = 'Create department';
	
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   
	
			$data['department'] = $this->model('Department_model')->getList();
	
			$this->view('templates/header_a', $data);
			$this->view('department/create', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}		
	}

	public function edit($id){
		$check = $this->model('Home_model')->checkUsermenu('department','Update');
        if ($check){
			$data['title'] = 'Edit department';
			$data['menu']  = 'Edit department';
	
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   
	
			$data['department']  = $this->model('Department_model')->getById($id);
	
			$this->view('templates/header_a', $data);
			$this->view('department/edit', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}	
	}

	public function save(){
		if( $this->model('Department_model')->save($_POST) > 0 ) {
			Flasher::setMessage('Data department Berhasil disimpan','','success');
			header('location: '. BASEURL . '/department');
			exit;			
		  }else{
			Flasher::setMessage('Gagal menyimpan data department,','','danger');
			header('location: '. BASEURL . '/department');
			exit;	
		  }
	}

	public function update(){
		if( $this->model('Department_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Data department Berhasil di edit','','success');
			header('location: '. BASEURL . '/department');
			exit;			
		  }else{
			Flasher::setMessage('Gagal edit data department,','','danger');
			header('location: '. BASEURL . '/department');
			exit;	
		  }
	}

	public function delete($kodebrg){
		$check = $this->model('Home_model')->checkUsermenu('department','Delete');
        if ($check){
			if( $this->model('Department_model')->delete($kodebrg) > 0 ) {
				Flasher::setMessage('Data department Berhasil dihapus','','success');
				header('location: '. BASEURL . '/department');
				exit;			
			}else{
				Flasher::setMessage('Gagal menghapus data department,','','danger');
				header('location: '. BASEURL . '/department');
				exit;	
			}
		}else{
			$this->view('templates/401');
		}	
		
	}
}