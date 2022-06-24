<?php

class Rwarehouseissuance_model{
    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function getReportData($strdate, $enddate){
        $this->db->query("SELECT * FROM t_warehouse_issuance WHERE issueance_date BETWEEN '$strdate' AND '$enddate'");
        return $this->db->resultSet();
    }
}