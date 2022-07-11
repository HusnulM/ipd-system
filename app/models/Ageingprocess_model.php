<?php

class Ageingprocess_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function getPartLotList($kepi_lot){
        $this->db->query("SELECT * FROM v_smt_handwork_data WHERE kepi_lot = '$kepi_lot' AND ageing_process = 'N'");
        return $this->db->resultSet();
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
        $query = "INSERT INTO t_ageing (kepi_lot, quantity, manpower_name, ageing_time, ageing_result, failure_remark, defect_quantity, assy_code, barcode_serial, part_lot, createdby, createdon) VALUES (:kepi_lot, :quantity, :manpower_name, :ageing_time, :ageing_result, :failure_remark, :defect_quantity, :assy_code, :barcode_serial, :part_lot, :createdby, :createdon)";
        $this->db->query($query);

        $defectQty = 0;
        if(isset($data['defect_qty']) && $data['defect_qty'] !== ''){
            $defectQty = $data['defect_qty'];
        }

        $this->db->bind('kepi_lot',        $data['kepilot']);
        $this->db->bind('quantity',        $data['quantity'] ?? 0);
        $this->db->bind('manpower_name',   $data['manpower_name']);
        $this->db->bind('ageing_time',     $data['ageing_time']);
        $this->db->bind('ageing_result',   $data['ageing_result'] ?? null);
        $this->db->bind('failure_remark',  $data['failure_remark'] ?? null);
        $this->db->bind('defect_quantity', $defectQty ?? 0);
        $this->db->bind('assy_code',       $data['assycode']);
        $this->db->bind('barcode_serial',  $data['qrcode']);
        $this->db->bind('part_lot',        $data['lotnumber']);
        $this->db->bind('createdby',       $_SESSION['usr']['user']);
        $this->db->bind('createdon',       date('Y-m-d H:m:s'));
        $this->db->execute();

        return $this->db->rowCount();
    }
}