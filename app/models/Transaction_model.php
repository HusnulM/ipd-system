<?php

class Transaction_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function getDataBySerial($serialno){
        $this->db->query("SELECT * FROM v_report_transaction where serial_no='$serialno'");
		return $this->db->single();
    }

    public function getDataTransid($transid){
        $this->db->query("SELECT * FROM t_ipd_process where transactionid='$transid'");
		return $this->db->single();
    }

    public function getRepairDataTransid($transid){
        $this->db->query("SELECT * FROM t_ipd_repair where transactionid='$transid'");
		return $this->db->single();
    }

    public function checNGStatus($transid){
        $this->db->query("SELECT * FROM t_ipd_process where transactionid='$transid' AND ( process1='NG' OR process2='NG' OR process3='NG' OR process4='NG' OR process5='NG' OR process6='NG')");
		return $this->db->single();
    }

    public function getProcessSequence($transtype){
        $user = $_SESSION['usr']['user'];
        $this->db->query("SELECT * FROM t_process_sequence where username='$user' and transtype='$transtype'");
		return $this->db->single();
    }

    public function getProcessSequenceNumber($sequence, $transtype){
        $user = $_SESSION['usr']['user'];
        $this->db->query("SELECT * FROM t_process_sequence where sequence='$sequence' and transtype='$transtype'");
		return $this->db->single();
    }

    public function saveform($data){
        $transid = date_create();
        $currentDate = date('Y-m-d');
        
        $query = "INSERT INTO t_ipd_forms (transactionid,prod_date,partnumber,partmodel,serial_no,createdon,createdby) 
                      VALUES(:transactionid,:prod_date,:partnumber,:partmodel,:serial_no,:createdon,:createdby)";
        $this->db->query($query);
        
        $this->db->bind('transactionid', date_timestamp_get($transid));
        $this->db->bind('prod_date',     $currentDate);
        $this->db->bind('partnumber',    $data['partnumber']);
        $this->db->bind('partmodel',     $data['partmodel']);
        $this->db->bind('serial_no',     $data['lotnumber']);
        $this->db->bind('createdon',     $currentDate);
        $this->db->bind('createdby',     $_SESSION['usr']['user']);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function saveprocess($data){
        $processSequence = $this->getProcessSequence('process');
        $currentDate = date('Y-m-d');
        $processStatus = '';

        if($data['status'] === "Other"){
            $processStatus = $data['otherstatus'];
        }else{
            $processStatus = $data['status'];
        }

        $checkExists     = $this->getDataTransid($data['formid']);
        if($checkExists){
                $sequence = $processSequence['sequence'];

                if($processStatus === "NG"){
                    $query = "UPDATE t_ipd_process SET process".$sequence."=:process".$sequence.",error_process=:error_process, defect_name=:defect_name, location=:location, cause=:cause, action=:action, lastprocess=:lastprocess WHERE transactionid=:transactionid";
                    $this->db->query($query);
            
                    $this->db->bind('transactionid',      $data['formid']);
                    $this->db->bind('process'.$sequence,  $processStatus);
                    if($processStatus === "NG"){
                        $this->db->bind('error_process',  $processSequence['processname']);
                    }else{
                        $this->db->bind('error_process',  '');
                    }
                    $this->db->bind('defect_name', $data['defect']);
                    $this->db->bind('location',    $data['location']);
                    $this->db->bind('cause',       $data['cause']);
                    $this->db->bind('action',      $data['action']);
                    $this->db->bind('lastprocess', $processSequence['sequence']);
                    $this->db->execute();
                    
                    if($processStatus === "NG"){
                        $this->createRepairForm($data);
                    }

                    return $this->db->rowCount();
                }else{
                    $query = "UPDATE t_ipd_process SET process".$sequence."=:process".$sequence.",error_process=:error_process, lastprocess=:lastprocess WHERE transactionid=:transactionid";
                    $this->db->query($query);
            
                    $this->db->bind('transactionid',      $data['formid']);
                    $this->db->bind('process'.$sequence,  $processStatus);
                    if($processStatus === "NG"){
                        $this->db->bind('error_process',  $processSequence['processname']);
                    }else{
                        $this->db->bind('error_process',  '');
                    }
                    $this->db->bind('lastprocess',  $processSequence['sequence']);
                    $this->db->execute();
                    
                    if($processStatus === "NG"){
                        $this->createRepairForm($data);
                    }

                    return $this->db->rowCount();
                }

        }else{
            if($processSequence['sequence'] == 1){

                $query1 = "INSERT INTO t_ipd_forms (transactionid,prod_date,partnumber,partmodel,serial_no,createdon,createdby) 
                      VALUES(:transactionid,:prod_date,:partnumber,:partmodel,:serial_no,:createdon,:createdby)";
                $this->db->query($query1);
                
                $this->db->bind('transactionid', $data['formid']);
                $this->db->bind('prod_date',     $currentDate);
                $this->db->bind('partnumber',    $data['partnumber']);
                $this->db->bind('partmodel',     $data['partmodel']);
                $this->db->bind('serial_no',     $data['_lotnumber']);
                $this->db->bind('createdon',     $currentDate);
                $this->db->bind('createdby',     $_SESSION['usr']['user']);
                $this->db->execute();

                $query = "INSERT INTO t_ipd_process (transactionid,process1,error_process,defect_name,location,cause,action,lastprocess) 
                VALUES(:transactionid,:process1,:error_process,:defect_name,:location,:cause,:action,:lastprocess)";
                $this->db->query($query);
        
                $this->db->bind('transactionid',  $data['formid']);
                $this->db->bind('process1',       $processStatus);
                if($processStatus === "NG"){
                    $this->db->bind('error_process',  $processSequence['processname']);
                }else{
                    $this->db->bind('error_process',  null);
                }
                $this->db->bind('defect_name', $data['defect']);
                $this->db->bind('location',    $data['location']);
                $this->db->bind('cause',       $data['cause']);
                $this->db->bind('action',      $data['action']);
                $this->db->bind('lastprocess', $processSequence['sequence']);
                $this->db->execute();
                
                if($processStatus === "NG"){
                    $this->createRepairForm($data);
                }
                return $this->db->rowCount();
            }else{

            }
        }
    }

    public function createRepairForm($data){
        $query = "INSERT INTO t_ipd_repair (transactionid,defect_name,location,action) 
                  VALUES(:transactionid,:defect_name,:location,:action)";
        $this->db->query($query);

        $this->db->bind('transactionid', $data['formid']);
        $this->db->bind('defect_name',   $data['defect']);
        $this->db->bind('location',      $data['location']);
        $this->db->bind('action',        $data['action']);
        $this->db->execute();
    }

    public function saveRepairForm($data){
        $processSequence = $this->getProcessSequence('repair');
        $sequence = $processSequence['sequence'];

        $remark = null;

        if(isset($data['remark'])){
            $remark = $data['remark'];
        }

        if($data['status'] === "Other"){
            $processStatus = $data['otherstatus'];
        }else{
            $processStatus = $data['status'];
        }

        $query = "UPDATE t_ipd_repair SET process".$sequence."=:process".$sequence.",lastrepair=:lastrepair, remark=:remark WHERE transactionid=:transactionid";
        
        $this->db->query($query);
            
        $this->db->bind('transactionid',      $data['formid']);
        $this->db->bind('process'.$sequence,  $processStatus);        
        $this->db->bind('remark',             $remark);
        $this->db->bind('lastrepair',         $processSequence['sequence']);
        $this->db->execute();
        return $this->db->rowCount();
    }
}