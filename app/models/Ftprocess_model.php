
<?php

class Ftprocess_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function getPartLotList($kepi_lot){
        $this->db->query("SELECT distinct assy_code, kepi_lot, barcode_serial, part_lot, fGetSMTAgeingProcess('1',kepi_lot, barcode_serial, part_lot) as smt_process, fGetSMTAgeingProcess('2',kepi_lot, barcode_serial, part_lot) as hw_process FROM v_smt_handwork_data WHERE kepi_lot = '$kepi_lot' AND part_lot NOT IN(SELECT part_lot FROM t_ft_process WHERE kepi_lot = '$kepi_lot') order by kepi_lot, barcode_serial, part_lot asc");
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
        $query = "INSERT INTO t_ft_process (kepi_lot, manpower_name, ft_time, ft_result, ft_quantity, failure_remark, defect_qty, assy_code, barcode_serial, part_lot, createdby, createdon) VALUES (:kepi_lot, :manpower_name, :ft_time, :ft_result, :ft_quantity, :failure_remark, :defect_qty, :assy_code, :barcode_serial, :part_lot, :createdby, :createdon)";
        $this->db->query($query);

        $defectQty = 0;
        if(isset($data['defect_qty']) && $data['defect_qty'] !== ''){
            $defectQty = $data['defect_qty'];
        }

        $this->db->bind('kepi_lot',        $data['kepilot']);
        $this->db->bind('manpower_name',   $data['manpower_name']);
        $this->db->bind('ft_time',         $data['ft_time']);
        $this->db->bind('ft_result',       $data['ft_result'] ?? null);
        $this->db->bind('ft_quantity',     $data['quantity'] ?? 0);
        $this->db->bind('failure_remark',  $data['ft_remark'] ?? null);
        $this->db->bind('defect_qty',      $defectQty);
        $this->db->bind('assy_code',       $data['assycode']);
        $this->db->bind('barcode_serial',  $data['qrcode']);
        $this->db->bind('part_lot',        $data['lotnumber']);
        $this->db->bind('createdby',       $_SESSION['usr']['user']);
        $this->db->bind('createdon',       date('Y-m-d H:m:s'));
        $this->db->execute();

        return $this->db->rowCount();
    }
}