<?php

class Cause_model{

    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function getCauseList(){
        $this->db->query('SELECT * FROM t_causelist');
        return $this->db->resultSet();
    }

    public function getCauseByid($id){
        $this->db->query("SELECT * FROM t_causelist WHERE id='$id'");
        return $this->db->single();
    }

    public function save($data){
        $currentDate = date('Y-m-d');
        
        $query = "INSERT INTO t_causelist (causename,createdon,createdby) 
                      VALUES(:causename,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('causename',     $data['causename']);
        $this->db->bind('createdon',     $currentDate);
        $this->db->bind('createdby',     $_SESSION['usr']['user']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function update($data){        
        $query = "UPDATE t_causelist set causename=:causename WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id',           $data['causeid']);
        $this->db->bind('causename',    $data['causename']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function delete($id){        
        $query = "DELETE FROM t_causelist WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id',         $id);
        $this->db->execute();
        
        return $this->db->rowCount();
    }
}