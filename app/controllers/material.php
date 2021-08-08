<?php

class Material extends Controller {
    public function __construct(){
        if( isset($_SESSION['usr']) ){
        }else{
            header('location:'. BASEURL);
        }
    }

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('material','Read');
        if ($check){
            $data['title'] = 'Material Master';
            $data['menu']  = 'Material Master';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         

            $data['material'] = $this->model('Material_model')->getListBarang();   

            // echo json_encode($data['showprice']);
            $this->view('templates/header_a', $data);
            $this->view('material/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('material','Create');
        if ($check){
            $data['title'] = 'Create Material';
            $data['menu']  = 'Create New Material';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();       
            

            $this->view('templates/header_a', $data);
            $this->view('material/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function edit($params){
        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $material = $params['material'];
        $check = $this->model('Home_model')->checkUsermenu('material','Update');
        if ($check){
            $data['title'] = 'Change Material';
            $data['menu']  = 'Change Material Master';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         

            $data['material'] = $this->model('Material_model')->getBarangByKode($material);
            // $data['altuom']   = $this->model('Barang_model')->getBarangBaseUomByKode($material, $data['material']['matunit']);
            
            // $data['mattype']   = $this->model('Barang_model')->getListMatType();
            // $data['cmattype']  = $this->model('Barang_model')->geMatTypeById($data['material']['mattype']);

            $this->view('templates/header_a', $data);
            $this->view('material/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function getMaterialbyCode($params){
        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $material = $params['material'];

        $data = $this->model('Material_model')->getBarangByKode($material);

        echo json_encode($data);
    }

    public function save(){
        if( $this->model('Material_model')->save($_POST) > 0 ) {
			Flasher::setMessage('New Material Created','','success');
			header('location: '. BASEURL . '/material');
			exit;			
		}else{
			Flasher::setMessage('Fail Create New Material,','','danger');
			header('location: '. BASEURL . '/material');
			exit;	
		}
    }
    
    public function update(){
        if( $this->model('Material_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Material Changed','','success');
			header('location: '. BASEURL . '/material');
			exit;			
		}else{
			Flasher::setMessage('Fail Change Material','','success');
			header('location: '. BASEURL . '/material');
			exit;
		}
	}

    public function delete($params){

        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $material = $params['material'];

        $check = $this->model('Home_model')->checkUsermenu('material','Delete');
        if ($check){
            if( $this->model('Material_model')->delete($material) > 0 ) {
                Flasher::setMessage('Material Deleted','','success');
                header('location: '. BASEURL . '/material');
                exit;			
            }else{
                Flasher::setMessage('Fail Delete Material,','','danger');
                header('location: '. BASEURL . '/material');
                exit;	
            }
        }else{
            $this->view('templates/401');
        }         
    }
}