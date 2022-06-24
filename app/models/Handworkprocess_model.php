<?php

class Handworkprocess_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function save($data){
        $query = "INSERT INTO t_handwork_process (assy_code, kepi_lot, part_lot, hw_line, hw_shift, createdby, createdon) VALUES (:assy_code, :kepi_lot, :part_lot, :hw_line, :hw_shift, :createdby, :createdon)";
        $this->db->query($query);

        $this->db->bind('assy_code', $data['assycode']);
        $this->db->bind('kepi_lot',  $data['kepilot']);
        $this->db->bind('part_lot',  $data['lotnumber']);
        $this->db->bind('hw_line',   $data['hwline'] ?? null);
        $this->db->bind('hw_shift',  $data['hwshift'] ?? null);
        $this->db->bind('createdby', $_SESSION['usr']['user']);
        $this->db->bind('createdon', date('Y-m-d H:m:s'));
        $this->db->execute();

        return $this->db->rowCount();
    }
}