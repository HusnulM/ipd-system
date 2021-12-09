<?php

class Warehouse_model{

    private $db;

    public function __construct(){
		  $this->db = new Database;
    }
    
    public function getList(){
        $this->db->query('SELECT * FROM t_gudang');
		return $this->db->resultSet();
    }

    public function getWarehouseByAuth(){
        $user = $_SESSION['usr']['user'];
        $this->db->query("CALL getWarehouseByObAuth('$user')");
	    return $this->db->resultSet();
    }

    public function getById($id){
        $this->db->query("SELECT * FROM t_gudang WHERE gudang='$id'");
		return $this->db->single();
    }

    public function  save($data){
        $currentDate = date('Y-m-d');
        $query = "INSERT INTO t_gudang (plant,gudang,deskripsi,active,createdon, createdby) 
                  VALUES(:plant,:gudang,:deskripsi,:active,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('plant',  '1000');
        $this->db->bind('gudang',    str_replace(" ","",$data['whscode']));
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('active',   '1');
        $this->db->bind('createdon',$currentDate);
        $this->db->bind('createdby',$_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function  update($data){
        $query = "UPDATE t_gudang set deskripsi=:deskripsi WHERE plant=:plant and gudang=:gudang";
        $this->db->query($query);
      
        $this->db->bind('plant',    '1000');
        $this->db->bind('gudang',   $data['whscode']);
        $this->db->bind('deskripsi',$data['deskripsi']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($id){
      $this->db->query("DELETE FROM t_gudang WHERE plant=:plant and gudang=:gudang");
      $this->db->bind('plant', '1000');
      $this->db->bind('gudang', $id);
      $this->db->execute();

      return $this->db->rowCount();
    }
}