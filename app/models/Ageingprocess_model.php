<?php

class Ageingprocess_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function checkKepiLot($kepi_lot){
        $this->db->query("SELECT a.*, b.matdesc FROM t_smt_line_process as a left join t_material as b on a.assy_code = b.material WHERE a.kepi_lot = '$kepi_lot'");
        return $this->db->single();
    }

    public function checkKepiLotAlreadyProcessed($kepi_lot){
        $this->db->query("SELECT * FROM t_ageing WHERE kepi_lot = '$kepi_lot'");
        return $this->db->single();
    }

    public function save($data){
        $query = "INSERT INTO t_ageing (kepi_lot, quantity, manpower_name, ageing_result, failure_remark, defect_quantity, createdby, createdon) VALUES (:kepi_lot, :quantity, :manpower_name, :ageing_result, :failure_remark, :defect_quantity, :createdby, :createdon)";
        $this->db->query($query);

        $this->db->bind('kepi_lot',        $data['kepilot']);
        $this->db->bind('quantity',        $data['quantity'] ?? 0);
        $this->db->bind('manpower_name',   $data['manpower_name']);
        $this->db->bind('ageing_result',   $data['ageing_result'] ?? null);
        $this->db->bind('failure_remark',  $data['failure_remark'] ?? null);
        $this->db->bind('defect_quantity', $data['defect_qty'] ?? 0);
        $this->db->bind('createdby',       $_SESSION['usr']['user']);
        $this->db->bind('createdon',       date('Y-m-d H:m:s'));
        $this->db->execute();

        return $this->db->rowCount();
    }
}