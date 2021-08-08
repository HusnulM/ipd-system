<?php

class Action_model{

    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function getActionList(){
        $this->db->query('SELECT * FROM t_actionlist');
        return $this->db->resultSet();
    }

    public function getActionByid($id){
        $this->db->query("SELECT * FROM t_actionlist WHERE id='$id'");
        return $this->db->single();
    }

    public function save($data){
        $currentDate = date('Y-m-d');
        
        $query = "INSERT INTO t_actionlist (actionname,createdon,createdby) 
                      VALUES(:actionname,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('actionname',    $data['actionname']);
        $this->db->bind('createdon',     $currentDate);
        $this->db->bind('createdby',     $_SESSION['usr']['user']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function update($data){        
        $query = "UPDATE t_actionlist set actionname=:actionname WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id',           $data['actionid']);
        $this->db->bind('actionname',   $data['actionname']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function delete($id){        
        $query = "DELETE FROM t_actionlist WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id',         $id);
        $this->db->execute();
        
        return $this->db->rowCount();
    }
}