<?php

class Barang extends Controller{
    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }
    
    public function index(){
		$data['title'] = 'Master Material';
		$data['menu']  = 'Master Material';
		$data['menu-dsc'] = '';

		$data['setting'] = $this->model('Setting_model')->getgensetting();
		$data['barang']  = $this->model('Barang_model')->getListBarang();

		$this->view('templates/header_a', $data);
		$this->view('barang/index', $data);
		$this->view('templates/footer_a');
    }

    public function create(){
        $data['title'] = 'Tambah Material';
		$data['menu']  = 'Tambah Material';
		$data['menu-dsc'] = '';

		$data['setting'] = $this->model('Setting_model')->getgensetting();

		$this->view('templates/header_a', $data);
		$this->view('barang/create', $data);
		$this->view('templates/footer_a');
	}

	public function edit($kodebrg){
        $data['title']    = 'Edit Barang';
		$data['menu']     = 'Edit Barang';
		$data['menu-dsc'] = '';

		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['brgedit']  = $this->model('Barang_model')->getBarangByKode($kodebrg);

		$this->view('templates/header_a', $data);
		$this->view('barang/edit', $data);
		$this->view('templates/footer_a');
	}

	public function caribarang($namabrg){
		$data = $this->model('Barang_model')->getBarangByName($namabrg);
		foreach ($data as $row):
			$row_out[] = array(
				'label'   => $row['kodebrg'] . ' ' . $row['namabrg']. ' ' . $row['satuan'],
                'value'   => $row['namabrg'],	
			);
		endforeach;	
		echo json_encode($row_out);
	}

	public function caribarangbykode($kodebarang){
		$data = $this->model('Barang_model')->getBarangByKode($kodebarang);
		echo json_encode($data);
	}

	public function listbarang(){
		$data['data'] = $this->model('Barang_model')->getListBarang();
		echo json_encode($data);
	}

	public function listbarangwithstock(){
		$data['data'] = $this->model('Barang_model')->getListBarangWithStock();
		echo json_encode($data);
	}

	public function getmaterialunit($matnr){
		$url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $matnr);
		$material = $matnr['material'];
		$unit     = $matnr['unit'];
		$data = $this->model('Barang_model')->getmaterialunit($material,$unit);
		echo json_encode($data);
	}

	public function save(){
		if( $this->model('Barang_model')->save($_POST) > 0 ) {
			Flasher::setMessage('Material Berhasil disimpan','','success');
			header('location: '. BASEURL . '/barang');
			exit;			
		  }else{
			Flasher::setMessage('Gagal menyimpan data material,','','danger');
			header('location: '. BASEURL . '/barang');
			exit;	
		  }
	}

	public function update(){
		if( $this->model('Barang_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Material Berhasil di edit','','success');
			header('location: '. BASEURL . '/barang');
			exit;			
		  }else{
			Flasher::setMessage('Gagal edit data material,','','danger');
			header('location: '. BASEURL . '/barang');
			exit;	
		  }
	}

	public function delete($kodebrg){
		if( $this->model('Barang_model')->delete($kodebrg) > 0 ) {
			Flasher::setMessage('Material Berhasil dihapus','','success');
			header('location: '. BASEURL . '/barang');
			exit;			
		  }else{
			Flasher::setMessage('Gagal menghapus data material,','','danger');
			header('location: '. BASEURL . '/barang');
			exit;	
		  }
	}
}