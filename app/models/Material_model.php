<?php

class Material_model{

  private $db;
	  private $table = 't_barang';

    public function __construct()
    {
		  $this->db = new Database;
    }
    
    public function getListBarang()
    {
      $this->db->query("SELECT * FROM t_material");
		  return $this->db->resultSet();
    }

    public function checkauthdisplayprice(){
      $user = $_SESSION['usr']['user'];
      $this->db->query("SELECT count(*) as 'rows' FROM t_user_object_auth WHERE ob_auth = 'OB_MATPRICE' AND username = '$user'");
		  return $this->db->single();
    }

    public function getusdtoidr(){
      $this->db->query("SELECT fCurrencyConvertion('USD','IDR') as 'kurs'");
      return $this->db->single(); 
    }

    public function getListBarangWithStock(){
      $this->db->query("SELECT material, matdesc, partnumber, partname, matunit, FORMAT(fGetMaterialTotalStock(material), '.', '@') as 'stock' FROM t_material");
		  return $this->db->resultSet();
    }

    public function getListMatType(){
      $this->db->query("SELECT * FROM t_materialtype");
		  return $this->db->resultSet();
    }

    public function geMatTypeById($mattype){
      $this->db->query("SELECT * FROM t_materialtype WHERE mattype = '$mattype'");
		  return $this->db->single();
    }

    public function getBarangByKode($kodebrg)
    {
      $this->db->query("SELECT * FROM t_material WHERE material='$kodebrg'");
		  return $this->db->single();
    }

    public function getBarangBaseUomByKode($kodebrg, $buom)
    {
      $this->db->query("SELECT * FROM t_material2 WHERE material='$kodebrg' and altuom <> '$buom'");
		  return $this->db->resultSet();
    }

    public function getNextNumber($object){
      $this->db->query("call sp_NextNriv('$object')");
      return $this->db->single();
    }

    public function getmaterialunit($matnr, $exclunit){
      $this->db->query("SELECT * FROM t_material2 where material = '$matnr' and altuom not in('$exclunit')");
      return $this->db->resultSet();
    }

    public function  save($data){
        $currentDate = date('Y-m-d h:m:s');
        
        $query = "INSERT INTO t_material (material,matdesc,matunit,createdon,createdby) 
                      VALUES(:material,:matdesc,:matunit,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('material',  $data['kodebrg']);
        $this->db->bind('matdesc',   $data['namabrg']);
        $this->db->bind('matunit',   $data['satuan']);
        $this->db->bind('createdon', $currentDate);
        $this->db->bind('createdby', $_SESSION['usr']['user']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function savealtuom($kodebrg, $data){

      $altuom = $data['altuom'];
      $currentDate = date('Y-m-d h:m:s');

      $query = "INSERT INTO t_material2 (material,altuom,convalt,baseuom,convbase,createdon,createdby) 
                      VALUES(:material,:altuom,:convalt,:baseuom,:convbase,:createdon,:createdby)
                      ON DUPLICATE KEY UPDATE convalt=:convalt,baseuom=:baseuom,convbase=:convbase";
      $this->db->query($query);
      
      for($i=0; $i<sizeof($altuom); $i++){
        $this->db->bind('material',  $kodebrg);
        $this->db->bind('altuom',    $altuom[$i]);
        $this->db->bind('convalt',   $data['altuomval'][$i]);
        $this->db->bind('baseuom',   $data['baseuom'][$i]);
        $this->db->bind('convbase',  $data['baseuomval'][$i]);
        $this->db->bind('createdon', $currentDate);
        $this->db->bind('createdby', $_SESSION['usr']['user']);
        $this->db->execute();
      }

      return $this->db->rowCount();
    }

    public function  update($data){
      $currentDate = date('Y-m-d h:m:s');
        $query = "INSERT INTO t_material (material,matdesc,matunit,createdon,createdby) 
        VALUES(:material,:matdesc,:matunit,:createdon,:createdby)
              ON DUPLICATE KEY UPDATE matdesc=:matdesc,matunit=:matunit";
        $this->db->query($query);
        
        $this->db->bind('material',  $data['kodebrg']);
        $this->db->bind('matdesc',   $data['namabrg']);
        $this->db->bind('matunit',   $data['satuan']);
        $this->db->bind('createdon', $currentDate);
        $this->db->bind('createdby', $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($kodebrg){
      $this->db->query("DELETE FROM t_material WHERE material=:material");
      $this->db->bind('material',$kodebrg);
      $this->db->execute();

      return $this->db->rowCount();
    }

    public function updatekursusdidr($newvalue){
        $newcurs = "";
        $newcurs = str_replace(".", "",  $newvalue);
        $query = "UPDATE t_kurs set kurs2=:kurs2 WHERE currency1=:currency1 AND currency2=:currency2";
        $this->db->query($query);
      
        $this->db->bind('currency1',   'USD');
        $this->db->bind('currency2',   'IDR');
        $this->db->bind('kurs2',        $newcurs);
        $this->db->execute();

        return $this->db->rowCount();
    }
}