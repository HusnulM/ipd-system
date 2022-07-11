<?php

class Qainspection_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function checkKepiLot($kepi_lot){
        $this->db->query("SELECT a.*, b.matdesc FROM v_smt_handwork_data as a left join t_material as b on a.assy_code = b.material WHERE a.kepi_lot = '$kepi_lot'");
        return $this->db->single();
    }

    public function checkKepiLotAlreadyProcessed($kepi_lot){
        $this->db->query("SELECT * FROM t_ageing WHERE kepi_lot = '$kepi_lot'");
        return $this->db->single();
    }

    public function save($data){
        $query = "INSERT INTO t_qa_inspection (kepi_lot, qty_inspected, qa_operator, qa_date, qa_result, failure_remark, defect_qty, createdby, createdon) VALUES (:kepi_lot, :qty_inspected, :qa_operator, :qa_date, :qa_result, :failure_remark, :defect_qty, :createdby, :createdon)";
        $this->db->query($query);

        $defectQty = 0;
        if(isset($data['qa_defect_qty']) && $data['qa_defect_qty'] !== ''){
            $defectQty = $data['qa_defect_qty'];
        }

        $this->db->bind('kepi_lot',             $data['kepilot']);
        $this->db->bind('qty_inspected',        $data['quantity'] ?? 0);
        $this->db->bind('qa_operator',          $data['manpower_name']);
        $this->db->bind('qa_date',              date('Y-m-d'));
        $this->db->bind('qa_result',            $data['qa_result']);
        $this->db->bind('failure_remark',       $data['qa_remark']);
        $this->db->bind('defect_qty',           $defectQty);
        // $this->db->bind('qa_result',            $data['qa_result']);
        $this->db->bind('createdby',            $_SESSION['usr']['user']);
        $this->db->bind('createdon',            date('Y-m-d H:m:s'));
        $this->db->execute();

        return $this->db->rowCount();
    }
}