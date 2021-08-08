<?php

class Role_model{

    private $db;

    public function __construct()
	{
		$this->db = new Database;
    }
    
    public function getList(){
        $this->db->query("SELECT * FROM t_role");
		return $this->db->resultSet();
    }

    public function getRoleById($id){
        $this->db->query("SELECT * FROM t_role where roleid='$id'");
		return $this->db->single();
    }

    public function  save($data){
        $currentDate = date('Y-m-d');
        $query = "INSERT INTO t_role (rolename,createdon,createdby) 
                      VALUES(:rolename,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('rolename', $data['rolename']);
        $this->db->bind('createdon',$currentDate);
        $this->db->bind('createdby',$_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function update($data){
        $query = "UPDATE t_menus set rolename=:rolename WHERE roleid=:roleid";
        $this->db->query($query);

        $this->db->bind('roleid',   $data['roleid']);
        $this->db->bind('rolename', $data['rolename']);
        $this->db->execute();

        return $this->db->rowCount();        
    }

    public function delete($id){
        $this->db->query("DELETE FROM t_role WHERE roleid=:roleid");
        $this->db->bind('roleid',$id);
        $this->db->execute();
  
        return $this->db->rowCount();
    }
}