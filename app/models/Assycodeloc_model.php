<?php

class Assycodeloc_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function getLocation(){
        $this->db->query("SELECT a.*, b.matdesc as 'model' FROM t_assy_location as a left join t_material as b on a.assy_code = b.material");
		return $this->db->resultSet();
    }

    public function getLocationById($uniq_id){
        $this->db->query("SELECT * FROM t_assy_location WHERE uniq_id='$uniq_id'");
        return $this->db->single();
    }

    public function save($data){
        $query = "INSERT INTO t_assy_location (assy_code,assy_location,part_number,uniq_id,createdon,createdby) 
                      VALUES(:assy_code,:assy_location,:part_number,:uniq_id,:createdon,:createdby)";
        $this->db->query($query);
      
        $this->db->bind('assy_code',        $data['assy_code']);
        $this->db->bind('assy_location',    $data['assy_location']);
        $this->db->bind('part_number',      $data['part_number']);
        $this->db->bind('uniq_id',          time());
        $this->db->bind('createdon',        date('Y-m-d'));
        $this->db->bind('createdby',        $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function update($data){
        $query = "UPDATE t_assy_location SET assy_location=:assy_location ,part_number=:part_number WHERE uniq_id=:uniq_id";
        $this->db->query($query);
      
        // $this->db->bind('assy_code',        $data['assy_code']);
        $this->db->bind('assy_location',    $data['assy_location']);
        $this->db->bind('part_number',      $data['part_number']);
        $this->db->bind('uniq_id',          $data['uniq_id']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($uniq_id){
        $query = "DELETE FROM t_assy_location WHERE uniq_id=:uniq_id";
        $this->db->query($query);

        $this->db->bind('uniq_id',          $uniq_id);
        $this->db->execute();

        return $this->db->rowCount();
    }
}