<?php

class Line_model{

    private $db;

    public function __construct()
	{
		$this->db = new Database;
    }

    public function getListProductionLines(){
        $this->db->query("SELECT * FROM t_production_lines order by id asc");
		return $this->db->resultSet();
    }

    public function getListProductionLinesById($id){
        $this->db->query("SELECT * FROM t_production_lines Where id='$id'");
		return $this->db->single();
    }

    public function  save($data){
        $currentDate = date('Y-m-d');
        $query = "INSERT INTO t_production_lines (description,createdon,createdby) 
                      VALUES(:description,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('description', $data['linename']);
        $this->db->bind('createdon',   $currentDate);
        $this->db->bind('createdby',   $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function update($data){
        $query = "UPDATE t_production_lines set description=:description WHERE id=:id";
        $this->db->query($query);

        $this->db->bind('id',          $data['idline']);
        $this->db->bind('description', $data['linename']);
        $this->db->execute();

        return $this->db->rowCount();        
    }

    public function delete($id){
        $query = "DELETE FROM t_production_lines WHERE id=:id";
        $this->db->query($query);

        $this->db->bind('id',   $id);
        $this->db->execute();

        return $this->db->rowCount();        
    }
}