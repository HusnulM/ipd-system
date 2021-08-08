<?php

class Menurole_model{

    private $db;

    public function __construct()
	{
		$this->db = new Database;
    }
    
    public function getListMenuRoleAssignment(){
        $this->db->query("SELECT a.roleid, c.rolename, a.menuid, b.menu FROM t_rolemenu as a INNER JOIN t_menus as b on a.menuid = b.id
        INNER JOIN t_role as c on a.roleid = c.roleid
        ORDER BY a.roleid, a.menuid ASC");
		return $this->db->resultSet();
    }

    public function getMenuById($id){
        $this->db->query("SELECT * FROM t_menus where id='$id'");
		return $this->db->single();
    }

    public function getMenuActivity($roleid, $menuid){
        $user = $_SESSION['usr']['user'];
        $this->db->query("SELECT * FROM t_role_avtivity where roleid='$roleid' AND menuid='$menuid'");
		return $this->db->resultSet();
    }

    public function  save($data){

        $menuid = $data['itm_idmenu'];
        // $menuid = $data['itm_idmenu'];

        $currentDate = date('Y-m-d');
        $query = "INSERT INTO t_rolemenu (roleid,menuid,createdon,createdby) 
                      VALUES(:roleid,:menuid,:createdon,:createdby)";
        $this->db->query($query);
        
        for($i = 0; $i < count($menuid); $i++){
            $this->db->bind('roleid',    $data['roleid']);
            $this->db->bind('menuid',    $menuid[$i]);
            $this->db->bind('createdon',$currentDate);
            $this->db->bind('createdby',$_SESSION['usr']['user']);
            $this->db->execute();
        }

        return $this->db->rowCount();
    }

    public function  saveActivity($data){

        $activity  = $data['activity'];

        $currentDate = date('Y-m-d');
        $query = "INSERT INTO t_role_avtivity (roleid,menuid,activity,status,createdon) 
                      VALUES(:roleid,:menuid,:activity,:status,:createdon)
                      ON DUPLICATE KEY UPDATE activity=:activity,status=:status,createdon=:createdon";
        $this->db->query($query);
        for($i = 0; $i < sizeof($activity); $i++){
            $this->db->bind('roleid',    $activity[$i]['roleid']);
            $this->db->bind('menuid',    $activity[$i]['menuid']);
            $this->db->bind('activity',  $activity[$i]['activity']);
            $this->db->bind('status',    $activity[$i]['status']);
            $this->db->bind('createdon', $currentDate);
            $this->db->execute();
        }
        return $this->db->rowCount();
    }

    public function update($data){
        $query = "UPDATE t_menus set menu=:menu, route=:route, type=:type, grouping=:grouping WHERE id=:id";
        $this->db->query($query);

        $this->db->bind('id',       $data['idmenu']);
        $this->db->bind('menu',     $data['menu']);
        $this->db->bind('route',    $data['route']);
        $this->db->bind('type',     $data['type']);
        $this->db->bind('grouping', $data['group']);
        $this->db->execute();

        return $this->db->rowCount();        
    }

    public function delete($roleid, $menuid){
        $query1 = "DELETE FROM t_role_avtivity WHERE roleid=:roleid and menuid=:menuid";
        $this->db->query($query1);
        $this->db->bind('roleid', $roleid);
        $this->db->bind('menuid', $menuid);
        $this->db->execute();

        $query = "DELETE FROM t_rolemenu WHERE roleid=:roleid and menuid=:menuid";
        $this->db->query($query);
        $this->db->bind('roleid', $roleid);
        $this->db->bind('menuid', $menuid);
        $this->db->execute();

        return $this->db->rowCount();        
    }
}