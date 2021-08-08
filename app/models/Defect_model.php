<?php

class Defect_model{

    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function getDefectList(){
        $this->db->query('SELECT * FROM t_defectlist');
        return $this->db->resultSet();
    }

    public function getDefectByid($id){
        $this->db->query("SELECT * FROM t_defectlist WHERE id='$id'");
        return $this->db->single();
    }

    public function save($data){
        $currentDate = date('Y-m-d');
        
        $query = "INSERT INTO t_defectlist (defectname,createdon,createdby) 
                      VALUES(:defectname,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('defectname',    $data['defectname']);
        $this->db->bind('createdon',     $currentDate);
        $this->db->bind('createdby',     $_SESSION['usr']['user']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function update($data){        
        $query = "UPDATE t_defectlist set defectname=:defectname WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id',         $data['defectid']);
        $this->db->bind('defectname', $data['defectname']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function delete($id){        
        $query = "DELETE FROM t_defectlist WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id',         $id);
        $this->db->execute();
        
        return $this->db->rowCount();
    }
}