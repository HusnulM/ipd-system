<?php

class Objauth extends Controller{
  public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }
    
    public function index(){
      $check = $this->model('Home_model')->checkUsermenu('objauth','Read');
      if ($check){
        $data['title'] = 'User Object Authorization';
        $data['menu']  = 'User Object Authorization';

        $data['setting']  = $this->model('Setting_model')->getgensetting();
        $data['appmenu']  = $this->model('Home_model')->getUsermenu();   
        
        $data['objauth']  = $this->model('Objauth_model')->getListobjauth();

        $this->view('templates/header_a', $data);
        $this->view('objauth/index', $data);
        $this->view('templates/footer_a');
      }else{
        $this->view('templates/401');
      }
    }

    public function create(){
      $check = $this->model('Home_model')->checkUsermenu('objauth','Create');
      if ($check){
        $data['title'] = 'Add User Object Authorization';
        $data['menu']  = 'Add User Object Authorization';
        $data['menu-dsc'] = '';

        $data['setting']  = $this->model('Setting_model')->getgensetting();
        $data['appmenu']  = $this->model('Home_model')->getUsermenu();   

        $data['user']     = $this->model('User_model')->userList();
        $data['objauth']  = $this->model('Objauth_model')->getListObjectAuth();

        $this->view('templates/header_a', $data);
        $this->view('objauth/create', $data);
        $this->view('templates/footer_a');
      }else{
        $this->view('templates/401');
      }      
  }
  
  public function edit($objauth){
    $check = $this->model('Home_model')->checkUsermenu('objauth','Update');
        if ($check){
            $data['title'] = 'Edit objauth';
            $data['menu']  = 'Edit objauth';

            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();   

            $data['objauth']    = $this->model('Objauth_model')->getobjauthByKode($objauth);

            $this->view('templates/header_a', $data);
            $this->view('objauth/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }    
    }
	
	public function save(){
        if( $this->model('Objauth_model')->save($_POST) > 0 ) {
            Flasher::setMessage('Data objauth Berhasil di simpan','','success');
            header('location: '. BASEURL . '/objauth');
            exit;			
        }else{
        Flasher::setMessage('Gagal menyimpan data objauth,','','danger');
        header('location: '. BASEURL . '/objauth');
        exit;	
        }
    }

    public function update(){
		if( $this->model('Objauth_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Data objauth Berhasil di edit','','success');
			header('location: '. BASEURL . '/objauth');
			exit;			
		}else{
			Flasher::setMessage('Gagal edit data objauth,','','danger');
			header('location: '. BASEURL . '/objauth');
			exit;	
		}
	}
  
  public function delete($user,$ob_auth,$ob_value){
    $check = $this->model('Home_model')->checkUsermenu('objauth','Delete');
      if ($check){
        if( $this->model('Objauth_model')->delete($user,$ob_auth,$ob_value) > 0 ) {
          Flasher::setMessage('Data objauth Berhasil','di Hapus','success');
          header('location: '. BASEURL . '/objauth');
          exit;			
        }else{
          Flasher::setMessage('Gagal menghapus data objauth,','','danger');
          header('location: '. BASEURL . '/objauth');
          exit;	
        }
      }else{
        $this->view('templates/401');
      }    
  }
}