<?php

class Userrole_model{

    private $db;

    public function __construct()
	{
		$this->db = new Database;
    }
    
    public function getListUserRoleAssignment(){
        $this->db->query("SELECT a.*, b.rolename, c.nama FROM t_user_role as a inner join t_role as b on a.roleid = b.roleid inner join t_user as c on a.username = c.username");
		return $this->db->resultSet();
    }

    public function getAssignmentById($roleid, $user){
        $this->db->query("SELECT a.*, b.rolename, c.nama FROM t_user_role as a inner join t_role as b on a.roleid = b.roleid inner join t_user as c on a.username = c.username where a.roleid='$id' and a.username ='$user'");
		return $this->db->single();
    }

    public function save($data){

        $roleid = $data['itm_roleid'];
        $rolenm = $data['itm_rolename'];

        $currentDate = date('Y-m-d');
        $query = "INSERT INTO t_user_role (username,roleid,createdon,createdby) 
                  VALUES(:username,:roleid,:createdon,:createdby)";
        $this->db->query($query);
        for($i = 0; $i < count($roleid); $i++){
            $this->db->bind('username',  $data['username']);
            $this->db->bind('roleid',    $roleid[$i]);
            $this->db->bind('createdon', $currentDate);
            $this->db->bind('createdby', $_SESSION['usr']['user']);
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

    public function delete($role,$user){
        $this->db->query("DELETE FROM t_user_role WHERE username=:username and roleid=:roleid");
        $this->db->bind('username',$user);
        $this->db->bind('roleid',  $role);
        $this->db->execute();
  
        return $this->db->rowCount();
    }
}