<?php

class Report_model{
    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function rtransaction($strdate, $enddate){
        $this->db->query("SELECT * FROM v_report_transaction where createdon BETWEEN '$strdate' AND '$enddate' order by transactionid, process_counter asc");
        return $this->db->resultSet();
    }
}