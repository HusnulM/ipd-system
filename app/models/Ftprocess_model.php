
<?php

class Ftprocess_model{

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
        $query = "INSERT INTO t_ft_process (kepi_lot, manpower_name, ft_jig_no, ft_result, ft_quantity, failure_remark, createdby, createdon) VALUES (:kepi_lot, :manpower_name, :ft_jig_no, :ft_result, :ft_quantity, :failure_remark, :createdby, :createdon)";
        $this->db->query($query);

        $this->db->bind('kepi_lot',        $data['kepilot']);
        $this->db->bind('manpower_name',   $data['manpower_name']);
        $this->db->bind('ft_jig_no',       $data['ft_jig_no'] ?? null);
        $this->db->bind('ft_result',       $data['ft_result'] ?? null);
        $this->db->bind('ft_quantity',     $data['quantity'] ?? 0);
        $this->db->bind('failure_remark',  $data['ft_remark'] ?? null);
        $this->db->bind('createdby',       $_SESSION['usr']['user']);
        $this->db->bind('createdon',       date('Y-m-d H:m:s'));
        $this->db->execute();

        return $this->db->rowCount();
    }
}