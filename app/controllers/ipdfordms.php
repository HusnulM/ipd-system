<?php

class Ipdfordms extends Controller {

    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With");
    }

    public function index(){

    }
    
    public function searchAssycode(){

        $url    = parse_url($_SERVER['REQUEST_URI']);
        $search = $url['query'];
        $search = str_replace("searchName=","",$search);

        $result['data'] = $this->model('Production_model')->searchMaterial($search);
        echo json_encode($result);
    }

    public function assycodeList(){
        // $url    = parse_url($_SERVER['REQUEST_URI']);
        // $search = $url['query'];Ipdfordms/assycodeList
        // $search = str_replace("searchName=","",$search);

        $result['data'] = $this->model('Material_model')->getListBarang();
        echo json_encode($result);
    }
}