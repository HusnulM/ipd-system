<?php

class Partlotdisposition_model{

    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function getKepiAgeingHeader($kepi){
        $this->db->query("SELECT a.*, b.matdesc as model FROM t_ageing as a inner join t_material as b on a.assy_code = b.material WHERE a.kepi_lot='$kepi' limit 1");
		return $this->db->single();
    }

    public function getKepiFTHeader($kepi){
        $this->db->query("SELECT a.*, b.matdesc as model FROM t_ft_process as a inner join t_material as b on a.assy_code = b.material WHERE a.kepi_lot='$kepi' limit 1");
		return $this->db->single();
    }

    public function getKepiDetails($kepi){
        $this->db->query("SELECT * FROM v_ageing_ft_data WHERE kepi_lot='$kepi'");
		return $this->db->resultSet();
    }

    public function saveUpdate1($data){
        if($data['ageing_result'] != ""){
            $query = "UPDATE t_ageing SET ageing_result=:ageing_result WHERE kepi_lot=:kepi_lot";
            $this->db->query($query);
            $this->db->bind('kepi_lot',       $data['kepi_lot_update']);
            $this->db->bind('ageing_result',  $data['ageing_result']);
            $this->db->execute();
        }

        if($data['ft_result'] != ""){
            $query2 = "UPDATE t_ft_process SET ft_result=:ft_result WHERE kepi_lot=:kepi_lot";
            $this->db->query($query2);
            $this->db->bind('kepi_lot',   $data['kepi_lot_update']);
            $this->db->bind('ft_result',  $data['ft_result']);
            $this->db->execute();
        }

        return 1;
        // return $this->db->rowCount();
    }

    public function saveUpdate2($data){
        if($data['part_ageing_result'] != ""){
            $query = "UPDATE t_ageing SET part_lot_result=:part_lot_result WHERE kepi_lot=:kepi_lot AND part_lot=:part_lot";
            $this->db->query($query);
            $this->db->bind('kepi_lot',        $data['kepi_part_lot_update']);
            $this->db->bind('part_lot',        $data['part_lot_selected']);
            $this->db->bind('part_lot_result', $data['part_ageing_result']);
            $this->db->execute();
        }

        if($data['part_ft_result'] != ""){
            $query2 = "UPDATE t_ft_process SET part_lot_result=:part_lot_result WHERE kepi_lot=:kepi_lot AND part_lot=:part_lot";
            $this->db->query($query2);
            $this->db->bind('kepi_lot',        $data['kepi_part_lot_update']);
            $this->db->bind('part_lot',        $data['part_lot_selected']);
            $this->db->bind('part_lot_result', $data['part_ft_result']);
            $this->db->execute();
        }

        return 1;
        // return $this->db->rowCount();
    }
}