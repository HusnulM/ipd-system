<?php

class Report_model{
    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function rtransaction($strdate, $enddate){
        // $this->db->query("SELECT * FROM v_report_transaction where createdon BETWEEN '$strdate' AND '$enddate' order by transactionid, process_counter asc");
        $this->db->query("SELECT a.*, b.defect as 'itmdefect', b.location as 'itmlocation', b.cause as 'itmcause', b.action as 'itmaction', b.repairaction as 'raction', b.repairremark FROM v_report_transaction as a left join t_defect_process as b on a.transactionid = b.transactionid and a.process_counter = b.counter where a.createdon BETWEEN '$strdate' AND '$enddate' order by a.transactionid, b.id, a.process_counter, a.repair_counter asc");
        return $this->db->resultSet();
    }
}