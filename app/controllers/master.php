<?php

class Master extends Controller {
    public function __construct(){
        if( isset($_SESSION['usr']) ){
        }else{
            header('location:'. BASEURL);
        }
    }

    // Starf of All Route for Defect List
    public function defect(){
        $check = $this->model('Home_model')->checkUsermenu('master/defect','Read');
        if ($check){
            $data['title'] = 'Defect List';
            $data['menu']  = 'Defect List';     

            $data['defect'] = $this->model('Defect_model')->getDefectList();   

            $this->view('templates/header_a', $data);
            $this->view('master-data/defect/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function createdefect(){
        $check = $this->model('Home_model')->checkUsermenu('master/defect','Create');
        if ($check){
            $data['title'] = 'Create New Defect List';
            $data['menu']  = 'Create New Defect List';

            $this->view('templates/header_a', $data);
            $this->view('master-data/defect/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function editdefect($id){
        $check = $this->model('Home_model')->checkUsermenu('master/defect','Update');
        if ($check){
            $data['title'] = 'Create New Defect List';
            $data['menu']  = 'Create New Defect List'; 
            
            $data['defect']   = $this->model('Defect_model')->getDefectByid($id);

            $this->view('templates/header_a', $data);
            $this->view('master-data/defect/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function savedefect(){
        if( $this->model('Defect_model')->save($_POST) > 0 ) {
			Flasher::setMessage('New Defect List Created','','success');
			header('location: '. BASEURL . '/master/defect');
			exit;			
		}else{
			Flasher::setMessage('Create New Defect List Failed,','','danger');
			header('location: '. BASEURL . '/master/defect');
			exit;	
		}
    }

    public function updatedefect(){
        if( $this->model('Defect_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Defect List Updated','','success');
			header('location: '. BASEURL . '/master/defect');
			exit;			
		}else{
			Flasher::setMessage('Update Defect List Failed,','','danger');
			header('location: '. BASEURL . '/master/defect');
			exit;	
		}
    }

    public function deletedefect($id){
        if( $this->model('Defect_model')->delete($id) > 0 ) {
			Flasher::setMessage('Defect List Deleted','','success');
			header('location: '. BASEURL . '/master/defect');
			exit;			
		}else{
			Flasher::setMessage('Delete Defect List Failed,','','danger');
			header('location: '. BASEURL . '/master/defect');
			exit;	
		}
    }
    // End of All Route for Defect List

    // Starf of All Route for Location List
    public function location(){
        $check = $this->model('Home_model')->checkUsermenu('master/location','Read');
        if ($check){
            $data['title'] = 'Location List';
            $data['menu']  = 'Location List';      

            $data['location'] = $this->model('Location_model')->getLocationList();   

            // echo json_encode($data['showprice']);
            $this->view('templates/header_a', $data);
            $this->view('master-data/location/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function createlocatoin(){
        $check = $this->model('Home_model')->checkUsermenu('master/location','Create');
        if ($check){
            $data['title'] = 'Create New Location List';
            $data['menu']  = 'Create New Location List';

            $this->view('templates/header_a', $data);
            $this->view('master-data/location/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function editlocation($id){
        $check = $this->model('Home_model')->checkUsermenu('master/location','Update');
        if ($check){
            $data['title'] = 'Change Location List';
            $data['menu']  = 'Change Location List';
            
            $data['location']   = $this->model('Location_model')->getLocationByid($id);

            $this->view('templates/header_a', $data);
            $this->view('master-data/location/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function savelocation(){
        if( $this->model('Location_model')->save($_POST) > 0 ) {
			Flasher::setMessage('New Location List Created','','success');
			header('location: '. BASEURL . '/master/location');
			exit;			
		}else{
			Flasher::setMessage('Create New Location List Failed,','','danger');
			header('location: '. BASEURL . '/master/location');
			exit;	
		}
    }

    public function updatelocation(){
        if( $this->model('Location_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Location List Updated','','success');
			header('location: '. BASEURL . '/master/location');
			exit;			
		}else{
			Flasher::setMessage('Update Location List Failed,','','danger');
			header('location: '. BASEURL . '/master/location');
			exit;	
		}
    }

    public function deletelocation($id){
        if( $this->model('Location_model')->delete($id) > 0 ) {
			Flasher::setMessage('Location List Deleted','','success');
			header('location: '. BASEURL . '/master/location');
			exit;			
		}else{
			Flasher::setMessage('Delete Location List Failed,','','danger');
			header('location: '. BASEURL . '/master/location');
			exit;	
		}
    }
    // End of All Route for Location List

    // Starf of All Route for Cause List
    public function cause(){
        $check = $this->model('Home_model')->checkUsermenu('master/cause','Read');
        if ($check){
            $data['title'] = 'Cause List';
            $data['menu']  = 'Cause List';    

            $data['cause'] = $this->model('Cause_model')->getCauseList();   

            $this->view('templates/header_a', $data);
            $this->view('master-data/cause/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function createcause(){
        $check = $this->model('Home_model')->checkUsermenu('master/cause','Create');
        if ($check){
            $data['title'] = 'Create New Cause List';
            $data['menu']  = 'Create New Cause List';
            
            $this->view('templates/header_a', $data);
            $this->view('master-data/cause/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function editcause($id){
        $check = $this->model('Home_model')->checkUsermenu('master/cause','Update');
        if ($check){
            $data['title'] = 'Change Cause List';
            $data['menu']  = 'Change Cause List'; 
            
            $data['cause']   = $this->model('Cause_model')->getCauseByid($id);

            $this->view('templates/header_a', $data);
            $this->view('master-data/cause/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function savecause(){
        if( $this->model('Cause_model')->save($_POST) > 0 ) {
			Flasher::setMessage('New Cause List Created','','success');
			header('location: '. BASEURL . '/master/cause');
			exit;			
		}else{
			Flasher::setMessage('Create New Cause List Failed,','','danger');
			header('location: '. BASEURL . '/master/cause');
			exit;	
		}
    }

    public function updatecause(){
        if( $this->model('Cause_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Location List Updated','','success');
			header('location: '. BASEURL . '/master/cause');
			exit;			
		}else{
			Flasher::setMessage('Update Cause List Failed,','','danger');
			header('location: '. BASEURL . '/master/cause');
			exit;	
		}
    }

    public function deletecause($id){
        if( $this->model('Cause_model')->delete($id) > 0 ) {
			Flasher::setMessage('Cause List Deleted','','success');
			header('location: '. BASEURL . '/master/cause');
			exit;			
		}else{
			Flasher::setMessage('Delete Cause List Failed,','','danger');
			header('location: '. BASEURL . '/master/cause');
			exit;	
		}
    }
    // End of All Route for Cause List

    // Starf of All Route for Action List
    public function action(){
        $check = $this->model('Home_model')->checkUsermenu('master/action','Read');
        if ($check){
            $data['title'] = 'Action List';
            $data['menu']  = 'Action List';      

            $data['action'] = $this->model('Action_model')->getActionList();   

            $this->view('templates/header_a', $data);
            $this->view('master-data/action/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function createaction(){
        $check = $this->model('Home_model')->checkUsermenu('master/action','Create');
        if ($check){
            $data['title'] = 'Create New Action List';
            $data['menu']  = 'Create New Action List';

            $this->view('templates/header_a', $data);
            $this->view('master-data/action/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function editaction($id){
        $check = $this->model('Home_model')->checkUsermenu('master/action','Update');
        if ($check){
            $data['title'] = 'Change Action List';
            $data['menu']  = 'Change Action List';
            
            $data['action']   = $this->model('Action_model')->getActionByid($id);

            $this->view('templates/header_a', $data);
            $this->view('master-data/action/edit', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function saveaction(){
        if( $this->model('Action_model')->save($_POST) > 0 ) {
			Flasher::setMessage('New Action List Created','','success');
			header('location: '. BASEURL . '/master/action');
			exit;			
		}else{
			Flasher::setMessage('Create New Action List Failed,','','danger');
			header('location: '. BASEURL . '/master/action');
			exit;	
		}
    }

    public function updateaction(){
        if( $this->model('Action_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Action List Updated','','success');
			header('location: '. BASEURL . '/master/action');
			exit;			
		}else{
			Flasher::setMessage('Update Action List Failed,','','danger');
			header('location: '. BASEURL . '/master/action');
			exit;	
		}
    }

    public function deleteaction($id){
        if( $this->model('Action_model')->delete($id) > 0 ) {
			Flasher::setMessage('Action List Deleted','','success');
			header('location: '. BASEURL . '/master/action');
			exit;			
		}else{
			Flasher::setMessage('Delete Action List Failed,','','danger');
			header('location: '. BASEURL . '/master/action');
			exit;	
		}
    }
    // End of All Route for Acition List
}