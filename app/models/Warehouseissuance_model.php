<?php

class Warehouseissuance_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function getAll(){
        $this->db->query("SELECT * FROM t_process_sequence");
		return $this->db->resultSet();
    }

    public function save($data){
        $query = "UPDATE t_process_sequence SET username=:username WHERE id=:id";
        $this->db->query($query);

        $this->db->bind('id',       $data['processid']);
        $this->db->bind('username', $data['pic']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function saveWHIssuance($data){
        $query = "INSERT INTO t_warehouse_issuance (part_number, part_lot, quantity, location, status, issueance_date, createdby, createdon) VALUES (:part_number,:part_lot, :quantity, :location, :status, :issueance_date, :createdby, :createdon)";
        $this->db->query($query);

        $this->db->bind('part_number', $data['assycode']);
        $this->db->bind('part_lot',    $data['lotnumber']);
        $this->db->bind('quantity',    $data['quantity']);
        $this->db->bind('location',    $data['assy_line'] ?? null);
        $this->db->bind('status',      $data['status'] ?? null);
        $this->db->bind('issueance_date',    $data['issue_date'] ?? null);
        $this->db->bind('createdby', $_SESSION['usr']['user']);
        $this->db->bind('createdon', date('Y-m-d'));
        $this->db->execute();

        return $this->db->rowCount();
    }
}