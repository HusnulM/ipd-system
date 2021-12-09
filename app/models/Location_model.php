<?php

class Location_model{

    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function getLocationList(){
        $this->db->query('SELECT * FROM t_locationlist');
        return $this->db->resultSet();
    }

    public function getLocationByid($id){
        $this->db->query("SELECT * FROM t_locationlist WHERE id='$id'");
        return $this->db->single();
    }

    public function save($data){
        $currentDate = date('Y-m-d');
        
        $query = "INSERT INTO t_locationlist (locationname,createdon,createdby) 
                      VALUES(:locationname,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('locationname',  $data['locationname']);
        $this->db->bind('createdon',     $currentDate);
        $this->db->bind('createdby',     $_SESSION['usr']['user']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function update($data){        
        $query = "UPDATE t_locationlist set locationname=:locationname WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id',           $data['locationid']);
        $this->db->bind('locationname', $data['locationname']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function delete($id){        
        $query = "DELETE FROM t_locationlist WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id',         $id);
        $this->db->execute();
        
        return $this->db->rowCount();
    }
}