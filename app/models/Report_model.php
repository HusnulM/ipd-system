<?php

class Report_model{
    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function rtransaction($strdate, $enddate){
      $this->db->query("SELECT DISTINCT a.*, b.process_defect, b.process_location, b.process_cause, b.process_action, b.process_remark, b.repair_defect, b.repair_location, b.repair_cause, b.repair_action, a.remark as repair_remark FROM v_report_transaction as a LEFT JOIN v_defect_process as b on a.transactionid = b.transactionid and a.process_counter = b.counter where a.createdon BETWEEN '$strdate' AND '$enddate' ORDER BY a.transactionid, a.process_counter, `a`.`repair_counter`, b.id ASC");
        // $this->db->query("SELECT DISTINCT a.*, b.process_defect, b.process_location, b.process_cause, b.process_action, b.process_remark, b.repair_defect, b.repair_location, b.repair_cause, b.repair_action, b.repair_remark FROM v_report_transaction as a LEFT JOIN v_defect_process as b on a.transactionid = b.transactionid and a.process_counter = b.counter and a.repair_counter = b.repair_counter where a.createdon BETWEEN '$strdate' AND '$enddate' ORDER by a.transactionid, b.repair_counter, b.id");

        // $this->db->query("SELECT a.*, b.defect as 'itmdefect', b.location as 'itmlocation', b.cause as 'itmcause', b.action as 'itmaction', b.repairaction as 'raction', b.repairremark FROM v_report_transaction as a left join t_defect_process as b on a.transactionid = b.transactionid and a.process_counter = b.counter where a.createdon BETWEEN '$strdate' AND '$enddate' order by a.transactionid, b.id, a.process_counter, a.repair_counter asc");
        return $this->db->resultSet();
    }
}