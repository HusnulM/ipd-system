<?php

class Menu_model{

    private $db;

    public function __construct()
	{
		$this->db = new Database;
    }
    
    public function getListMenu(){
        $this->db->query("SELECT a.*, b.description as 'group' FROM t_menus as a inner join t_menugroups as b on a.menugroup = b.menugroup order by a.menugroup, a.id asc");
		return $this->db->resultSet();
    }

    public function getListMenugroups(){
        $this->db->query("SELECT * FROM t_menugroups");
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
        $query = "INSERT INTO t_menus (menu,route,type,icon,menugroup,createdon,createdby) 
                      VALUES(:menu,:route,:type,:icon,:menugroup,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('menu',     $data['menu']);
        $this->db->bind('route',    $data['route']);
        $this->db->bind('type',     'parent');
        $this->db->bind('icon',     '');
        $this->db->bind('menugroup', $data['group']);
        $this->db->bind('createdon',$currentDate);
        $this->db->bind('createdby',$_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function update($data){
        $query = "UPDATE t_menus set menu=:menu, route=:route, menugroup=:menugroup WHERE id=:id";
        $this->db->query($query);

        $this->db->bind('id',       $data['idmenu']);
        $this->db->bind('menu',     $data['menu']);
        $this->db->bind('route',    $data['route']);
        $this->db->bind('menugroup', $data['group']);
        $this->db->execute();

        return $this->db->rowCount();        
    }
}