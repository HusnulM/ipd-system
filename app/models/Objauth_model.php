<?php

class Objauth_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }
    
    public function getListobjauth()
    {
      $this->db->query("SELECT a.*, b.description FROM t_user_object_auth as a inner join t_auth_object as b on a.ob_auth = b.ob_auth");
		  return $this->db->resultSet();
    }

    public function getListObjectAuth()
    {
      $this->db->query("SELECT * FROM t_auth_object");
		  return $this->db->resultSet();
    }

    public function  save($data){
        $currentDate = date('Y-m-d h:m:s');
        $query = "INSERT INTO t_user_object_auth (username,ob_auth,ob_value,createdon,createdby) 
                      VALUES(:username,:ob_auth,:ob_value,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('username',  $data['username']);
        $this->db->bind('ob_auth',   $data['ob_auth']);
        $this->db->bind('ob_value',  $data['ob_value']);
        $this->db->bind('createdon', $currentDate);
        $this->db->bind('createdby', $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function  update($data){

        $this->delete($data['username'],$data['ob_auth'],$data['ob_value']);

        $currentDate = date('Y-m-d h:m:s');
        $query = "INSERT INTO t_user_object_auth (username,ob_auth,ob_value,createdon,createdby) 
                      VALUES(:username,:ob_auth,:ob_value,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('username',  $data['username']);
        $this->db->bind('ob_auth',   $data['ob_auth']);
        $this->db->bind('ob_value',  $data['ob_value']);
        $this->db->bind('createdon', $currentDate);
        $this->db->bind('createdby', $_SESSION['usr']['user']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function delete($user,$ob_auth,$ob_value){
      $this->db->query("DELETE FROM t_user_object_auth WHERE username=:username and ob_auth=:ob_auth and ob_value=:ob_value");
      $this->db->bind('username',$user);
      $this->db->bind('ob_auth', $ob_auth);
      $this->db->bind('ob_value',$ob_value);
      $this->db->execute();

      return $this->db->rowCount();
    }
}