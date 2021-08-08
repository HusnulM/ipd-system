<?php

class Home_model{

	private $db;
	private $table = 't_user';

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getUsermenu(){
		if( isset($_SESSION['usr']) ){
			$data['menugroups'] = $this->getUsermenugroups();
			$data['menus']      = $this->getUserAuthmenu();

			return $data;
		}
	}

	public function getUsermenugroups(){
		if( isset($_SESSION['usr']) ){
			$user = $_SESSION['usr']['user'];
			
			$this->db->query("SELECT distinct * FROM v_user_menugroup WHERE username='$user'");
			return $this->db->resultSet();
		}
	}

	public function getUserAuthmenu(){
		if( isset($_SESSION['usr']) ){
			$user = $_SESSION['usr']['user'];
			
			$this->db->query("SELECT distinct username,menuid,menu,route,type,menugroup,icon FROM v_user_menu WHERE username='$user' and type='parent'");
			return $this->db->resultSet();
		}
	}

	public function checkUsermenu($menu, $activity){
		if( isset($_SESSION['usr']) ){
			$user = $_SESSION['usr']['user'];
			// $this->db->query("SELECT * FROM v_user_menu WHERE route='$menu' and username='$user'");
			$this->db->query("SELECT * FROM v_user_role_avtivity WHERE route='$menu' and username='$user' and activity='$activity' and status = '1'");
			return $this->db->single();
		}
	}

	public function getuserdata($user){
		$this->db->query("SELECT * FROM t_user WHERE username=:username");
		$this->db->bind('username',$user);
		$this->db->execute();

		return $this->db->single();
	}

	public function getNextNumber($object){
		$this->db->query("CALL sp_NextNriv('$object')");
		return $this->db->single();
	} 

	public function register($data){

		$this->db->query('SELECT * FROM t_user WHERE username=:username');
		$this->db->bind('username',$data['username']);
		$this->db->execute();
		$result = $this->db->rowCount();

		if($result > 0 ){
			return 'X';
		}else{
			$currentDate = date('Y-m-d');
			$options = [
			    'cost' => 12,
			];
			$password = password_hash($data['password'], PASSWORD_BCRYPT, $options);

			$query = "INSERT INTO t_user (username, password, nama, userlevel, telp, alamat, createdby, createdon) 
					  VALUES(:username, :password, :nama, :userlevel, :telp, :alamat, :createdby, :createdon)";
			$this->db->query($query);
			$this->db->bind('username',   $data['username']);
			$this->db->bind('password',   $password);
			$this->db->bind('nama',       $data['nama']);
			$this->db->bind('userlevel',  $data['typeuser']);
			$this->db->bind('telp',       $data['telp']);		
			$this->db->bind('alamat',     $data['alamat']);
			$this->db->bind('createdby',  $_SESSION['usr']['user']);
			$this->db->bind('createdon',  $currentDate);			
			$this->db->execute();

			return $this->db->rowCount();
		}
	}


	public function login($data){
		$this->db->query("SELECT * FROM t_user WHERE username=:username");
		$this->db->bind('username',$data['username']);
		$this->db->execute();
		$result = $this->db->rowCount();

		if($result > 0 ){
			$options = [
			    'cost' => 12,
			];
			$password = password_hash($data['password'], PASSWORD_BCRYPT, $options);
			$usrdata = $this->db->single();
			if (password_verify($data['password'], $usrdata['password'])) {
			    return $usrdata;
			} 
			else {
			    return false;
			}			
		}else{
			return 'X';
		}
	}

	public function resetdata(){
		$this->db->query("CALL sp_ResetData()");
		$this->db->execute();

		return '1';
	}
}