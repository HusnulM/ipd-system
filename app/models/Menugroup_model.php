<?php

class Menugroup_model{

    private $db;

    public function __construct()
	{
		$this->db = new Database;
    }

    public function getListMenugroups(){
        $this->db->query("SELECT * FROM t_menugroups order by _index asc");
		return $this->db->resultSet();
    }

    public function getMenugroupByid($id){
        $this->db->query("SELECT * FROM t_menugroups Where menugroup='$id'");
		return $this->db->single();
    }

    public function getMenuById($id){
        $this->db->query("SELECT * FROM t_menus where id='$id'");
		return $this->db->single();
    }

    public function  save($data){
        $currentDate = date('Y-m-d');
        $query = "INSERT INTO t_menugroups (description,_index,icon,createdon,createdby) 
                      VALUES(:description,:_index,:icon,:createdon,:createdby)";
        $this->db->query($query);
        
        // $this->db->bind('menugroup',   $data['menugroup']);
        $this->db->bind('description', $data['menugroup']);
        $this->db->bind('_index',      $data['groupindex']);
        $this->db->bind('icon',        'storage');
        $this->db->bind('createdon',   $currentDate);
        $this->db->bind('createdby',   $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function update($data){
        $query = "UPDATE t_menugroups set description=:description, _index=:_index WHERE menugroup=:menugroup";
        $this->db->query($query);

        $this->db->bind('menugroup',   $data['idgroup']);
        $this->db->bind('description', $data['menugroup']);
        $this->db->bind('_index',      $data['groupindex']);
        $this->db->execute();

        return $this->db->rowCount();        
    }

    public function delete($id){
        $query = "DELETE FROM t_menugroups WHERE menugroup=:menugroup";
        $this->db->query($query);

        $this->db->bind('menugroup',   $id);
        $this->db->execute();

        return $this->db->rowCount();        
    }
}