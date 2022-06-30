<?php

class Smtprocess_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function save($data){
        // t_smt_line_process
        $query = "INSERT INTO t_smt_line_process (assy_code, kepi_lot, barcode_serial, part_lot, smt_line, smt_shift, createdby, createdon) VALUES (:assy_code, :kepi_lot, :barcode_serial, :part_lot, :smt_line, :smt_shift, :createdby, :createdon)";
        $this->db->query($query);

        $this->db->bind('assy_code', $data['assycode']);
        $this->db->bind('kepi_lot',  $data['kepilot']);
        $this->db->bind('barcode_serial',  $data['barcode']);
        $this->db->bind('part_lot',  $data['lotnumber']);
        $this->db->bind('smt_line',  $data['smtline'] ?? null);
        $this->db->bind('smt_shift', $data['smtshift'] ?? null);
        $this->db->bind('createdby', $_SESSION['usr']['user']);
        $this->db->bind('createdon', date('Y-m-d H:m:s'));
        $this->db->execute();

        return $this->db->rowCount();
    }
}