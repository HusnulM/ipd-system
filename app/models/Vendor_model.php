<?php

class Vendor_model{
    private $db;
	private $table = 't_vendor';

	public function __construct()
	{
		$this->db = new Database;
    }

    public function getListVendor()
    {
      $this->db->query('SELECT * FROM t_vendor');
		  return $this->db->resultSet();
    }

    public function getVendorByKode($vendor)
    {
      $this->db->query("SELECT * FROM t_vendor WHERE vendor='$vendor'");
		  return $this->db->single();
    }

    public function getVendorByName($name)
    {
        $this->db->query("SELECT * FROM t_vendor WHERE namavendor like '%" . $name . "%'");
		return $this->db->resultSet();
    }

    public function getNextNumber($object){
		$this->db->query("call sp_NextNriv('$object')");
		return $this->db->single();
	}
    
    public function save($data){

            $currentDate = date('Y-m-d');
            $vendor = $this->getNextNumber('VENDOR');
            $query = "INSERT INTO t_vendor (vendor, namavendor, alamat, notelp, email, createdon, createdby) 
                    VALUES(:vendor,:namavendor,:alamat,:notelp,:email,:createdon,:createdby)";
            $this->db->query($query);
            
            $this->db->bind('vendor',    $vendor['nextnumb']);
            $this->db->bind('namavendor',$data['namavendor']);
            $this->db->bind('alamat',    $data['alamat']);
            $this->db->bind('notelp',    $data['telp']);
            $this->db->bind('email',     $data['email']);
            $this->db->bind('createdon', $currentDate);
            $this->db->bind('createdby', $_SESSION['usr']['user']);
            $this->db->execute();

            // $this->db->commit();

            return $this->db->rowCount();     
    }

    public function  update($data){
		$query = "UPDATE t_vendor set namavendor=:namavendor, alamat=:alamat, notelp=:notelp, email=:email WHERE vendor=:vendor";
		$this->db->query($query);
		
        $this->db->bind('vendor',    $data['vendor']);
        $this->db->bind('namavendor',$data['namavendor']);
        $this->db->bind('alamat',    $data['alamat']);
        $this->db->bind('notelp',    $data['telp']);
        $this->db->bind('email',     $data['email']);
		$this->db->execute();

		return $this->db->rowCount();
    }

    public function delete($vendor){
        $this->db->query('DELETE FROM t_vendor WHERE vendor=:vendor');
		$this->db->bind('vendor',$vendor);
		$this->db->execute();

		return $this->db->rowCount();
    }
}