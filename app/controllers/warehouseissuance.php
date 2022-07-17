<?php

class Warehouseissuance extends Controller {
    public function __construct(){
		if( isset($_SESSION['usr']) ){
		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
      $check = $this->model('Home_model')->checkUsermenu('warehouseissuance','Read');
      if ($check){
          $data['title'] = 'WAREHOUSE ISSUANCE';
          $data['menu']  = 'WAREHOUSE ISSUANCE';  

          $data['lines'] = $this->model('Line_model')->getListProductionLines();

          $this->view('templates/header_a', $data);
          $this->view('warehouseissuance/index2', $data);
          $this->view('templates/footer_a');
      }else{
          $this->view('templates/401');
      }    
    }

    public function getpartlotageingft($params){
        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $partnumber = $params['partnumber'];
        $partlot    = $params['partlotnum'];

        $data['ageing'] = $this->model('Warehouseissuance_model')->getpartlotageing($partnumber,$partlot);
        $data['ft']     = $this->model('Warehouseissuance_model')->getpartlotft($partnumber,$partlot);
        echo json_encode($data);
    }

    public function saveWhIssuance(){
      // echo json_encode($_POST);
      $checBarcode = $this->model('Warehouseissuance_model')->getWareHouseIssuanceByBarcode($_POST['barcode']);
      if($checBarcode){
        Flasher::setMessage('POKANON QR CODE '. $_POST['barcode'] .' Already Use','','danger');
        header('location: '. BASEURL . '/warehouseissuance');
        exit;	
      }else{
        if( $this->model('Warehouseissuance_model')->saveWHIssuance($_POST) > 0 ) {
          Flasher::setMessage('Warehouse Issuance Created','','success');
          header('location: '. BASEURL . '/warehouseissuance');
          exit;			
        }else{
          Flasher::setMessage('Create Warehouse Issuance Failed','','danger');
          header('location: '. BASEURL . '/warehouseissuance');
          exit;	
        }
      }
    }
}