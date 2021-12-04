<?php

class Transaction_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function getDataBySerial($serialno){
        $this->db->query("SELECT * FROM v_report_transaction where serial_no='$serialno' order by process_counter desc");
		return $this->db->single();
    }

    public function getRepairDataBySerial($serialno){
        $this->db->query("SELECT * FROM v_report_transaction where serial_no='$serialno' order by repair_counter desc");
		return $this->db->single();
    }

    public function getDataTransid($transid){
        $this->db->query("SELECT * FROM t_ipd_process where transactionid='$transid' order by counter desc");
		return $this->db->single();
    }

    public function getRepairDataTransid($transid){
        $this->db->query("SELECT * FROM t_ipd_repair where transactionid='$transid' order by counter desc");
		return $this->db->single();
    }

    public function checNGStatus($transid){
        $this->db->query("SELECT * FROM t_ipd_process where transactionid='$transid' AND status = 'Open' AND ( process1='NG' OR process2='NG' OR process3='NG' OR process4='NG' OR process5='NG' OR process6='NG') order by counter desc");
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

    public function readDefectData($transid){
        $data = $this->getDataTransid($transid);
        $counter = $data['counter'];
        // return $counter;
        $this->db->query("SELECT * FROM t_defect_process where transactionid='$transid' and counter = '$counter'  order by counter desc");
		return $this->db->resultSet();
    }

    public function saveform($data){
        $transid = date_create();
        $currentDate = date('Y-m-d H:m:s');
        
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
        $transactionData = $this->getDataTransid($data['formid']);
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
                    // $query = "UPDATE t_ipd_process SET process".$sequence."=:process".$sequence.",error_process=:error_process, defect_name=:defect_name, location=:location, cause=:cause, action=:action, lastprocess=:lastprocess WHERE transactionid=:transactionid and counter=:counter";
                    $query = "UPDATE t_ipd_process SET process".$sequence."=:process".$sequence.",error_process=:error_process, lastprocess=:lastprocess WHERE transactionid=:transactionid and counter=:counter";
                    $this->db->query($query);
            
                    $this->db->bind('transactionid',      $data['formid']);
                    $this->db->bind('process'.$sequence,  $processStatus);
                    if($processStatus === "NG"){
                        $this->db->bind('error_process',  $processSequence['processname']);
                    }else{
                        $this->db->bind('error_process',  '');
                    }
                    // $this->db->bind('defect_name', $data['defect']);
                    // $this->db->bind('location',    $data['location']);
                    // $this->db->bind('cause',       $data['cause']);
                    // $this->db->bind('action',      $data['action']);
                    $this->db->bind('lastprocess', $processSequence['sequence']);
                    $this->db->bind('counter',     $transactionData['counter']);
                    $this->db->execute();

                    $defect   = $data['defectItem'];
                    $location = $data['locationItem'];
                    $cause    = $data['causeItem'];
                    $action   = $data['actionItem'];
                    
                    $insertDefect = "INSERT INTO t_defect_process (transactionid,counter,defect,location,cause,action,createdon,createdby) 
                      VALUES(:transactionid,:counter,:defect,:location,:cause,:action,:createdon,:createdby)";
                    $this->db->query($insertDefect);

                    for($i = 0; $i < sizeof($defect); $i++){
                        $this->db->bind('transactionid',      $data['formid']);
                        $this->db->bind('counter',     $transactionData['counter']);
                        $this->db->bind('defect',      $defect[$i]);
                        $this->db->bind('location',    $location[$i]);
                        $this->db->bind('cause',       $cause[$i]);
                        $this->db->bind('action',      $action[$i]);
                        $this->db->bind('createdon',   $currentDate);
                        $this->db->bind('createdby',   $_SESSION['usr']['user']);
                        $this->db->execute();
                    }

                    if($processStatus === "NG"){
                        $this->createRepairForm($data);
                    }

                    return $this->db->rowCount();
                }else{
                    $query = "UPDATE t_ipd_process SET process".$sequence."=:process".$sequence.",error_process=:error_process, lastprocess=:lastprocess WHERE transactionid=:transactionid and counter=:counter";
                    $this->db->query($query);
            
                    $this->db->bind('transactionid',      $data['formid']);
                    $this->db->bind('process'.$sequence,  $processStatus);
                    if($processStatus === "NG"){
                        $this->db->bind('error_process',  $processSequence['processname']);
                    }else{
                        $this->db->bind('error_process',  '');
                    }
                    $this->db->bind('lastprocess',  $processSequence['sequence']);
                    $this->db->bind('counter',      $transactionData['counter']);
                    $this->db->execute();
                    
                    if($processStatus === "NG"){
                        $this->createRepairForm($data);
                    }

                    return $this->db->rowCount();
                }

        }else{
            if($processSequence['sequence'] == 1){

                $query1 = "INSERT INTO t_ipd_forms (transactionid,prod_date,partnumber,partmodel,serial_no,lotcode,createdon,createdby) 
                      VALUES(:transactionid,:prod_date,:partnumber,:partmodel,:serial_no,:lotcode,:createdon,:createdby)";
                $this->db->query($query1);
                
                $this->db->bind('transactionid', $data['formid']);
                $this->db->bind('prod_date',     $currentDate);
                $this->db->bind('partnumber',    $data['partnumber']);
                $this->db->bind('partmodel',     $data['partmodel']);
                $this->db->bind('serial_no',     $data['_lotnumber']);
                $this->db->bind('lotcode',       $data['lotcode']);
                $this->db->bind('createdon',     $currentDate);
                $this->db->bind('createdby',     $_SESSION['usr']['user']);
                $this->db->execute();

                // $query = "INSERT INTO t_ipd_process (transactionid,counter,status,process1,error_process,defect_name,location,cause,action,lastprocess) 
                // VALUES(:transactionid,:counter,:status,:process1,:error_process,:defect_name,:location,:cause,:action,:lastprocess)";
                $query = "INSERT INTO t_ipd_process (transactionid,counter,status,process1,error_process,lastprocess) 
                VALUES(:transactionid,:counter,:status,:process1,:error_process,:lastprocess)";
                $this->db->query($query);
        
                $this->db->bind('transactionid',  $data['formid']);
                $this->db->bind('counter',        1);
                $this->db->bind('status',         'Open');
                $this->db->bind('process1',       $processStatus);
                if($processStatus === "NG"){
                    $this->db->bind('error_process',  $processSequence['processname']);
                }else{
                    $this->db->bind('error_process',  null);
                }
                // $this->db->bind('defect_name', $data['defect']);
                // $this->db->bind('location',    $data['location']);
                // $this->db->bind('cause',       $data['cause']);
                // $this->db->bind('action',      $data['action']);
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
        $transactionData = $this->getDataTransid($data['formid']);
        $lastRepair = $this->getRepairDataTransid($data['formid']);
        // $query = "INSERT INTO t_ipd_repair (transactionid,counter,process_counter,action,status,defect_name,location) 
        //           VALUES(:transactionid,:counter,:process_counter,:action,:status,:defect_name,:location)";
        $query = "INSERT INTO t_ipd_repair (transactionid,counter,process_counter,status) 
        VALUES(:transactionid,:counter,:process_counter,:status)";                  
        $this->db->query($query);

        $this->db->bind('transactionid',   $data['formid']);
        $this->db->bind('counter',         $lastRepair['counter']+1);
        $this->db->bind('process_counter', $transactionData['counter']);
        if($transactionData['lastprocess'] >= 5){
            $this->db->bind('status',      'Open');
            // $this->db->bind('action',          null);    
        }else{
            $this->db->bind('status',      'Closed');
            // $this->db->bind('action',          null);
            // $this->db->bind('action',          $data['action']);    
        }
        // $this->db->bind('defect_name',     $data['defect']);
        // $this->db->bind('location',        $data['location']);
        $this->db->execute();
    }

    public function saveRepairForm($data){
        $processSequence = $this->getProcessSequence('repair');
        $sequence = $processSequence['sequence'];
        $lastRepairData = $this->getRepairDataTransid($data['formid']);

        $remark = null;

        if(isset($data['remark'])){
            $remark = $data['remark'];
        }

        if($data['status'] === "Other"){
            $processStatus = $data['otherstatus'];
        }else{
            $processStatus = $data['status'];
        }

        $query = "UPDATE t_ipd_repair SET process".$sequence."=:process".$sequence.",lastrepair=:lastrepair, remark=:remark WHERE transactionid=:transactionid and counter=:counter";
        
        $this->db->query($query);
            
        $this->db->bind('transactionid',      $data['formid']);
        $this->db->bind('counter',            $lastRepairData['counter']);
        $this->db->bind('process'.$sequence,  $processStatus);        
        $this->db->bind('remark',             $remark);
        $this->db->bind('lastrepair',         $processSequence['sequence']);
        // $this->db->bind('action',             $data['actionName']);
        $this->db->execute();

        $transactionData = $this->getDataTransid($data['formid']);

        if($sequence == 1){
            $defectid = $data['defectId'];
            $defect   = $data['defectItem'];                    
            $location = $data['locationItem'];
            $cause    = $data['causeItem'];
            $action   = $data['actionItem'];
            $raction  = $data['repairactionItem'];
            // $remark   = $data['remarkItem'];
            
            $insertDefect = "UPDATE t_defect_process set repairaction=:repairaction, repairremark=:repairremark WHERE transactionid=:transactionid and id=:id";
            $this->db->query($insertDefect);

            for($i = 0; $i < sizeof($defect); $i++){
                $this->db->bind('transactionid', $data['formid']);
                $this->db->bind('id',            $defectid[$i]);
                $this->db->bind('repairaction',  $raction[$i]);
                $this->db->bind('repairremark',  $remark);
                $this->db->execute();
            }            

            $insertDefectRepair = "INSERT INTO t_defect_repair (transactionid,counter,defect_process_id,repair_counter,process_counter,defect,location,cause,action,remark,createdby,createdon) VALUES(:transactionid,:counter,:defect_process_id,:repair_counter,:process_counter,:defect,:location,:cause,:action,:remark,:createdby,:createdon)";
            
            $this->db->query($insertDefectRepair);
                
                $icount = 0;
                for($i = 0; $i < sizeof($defect); $i++){
                    $icount = $icount + 1;
                    $this->db->bind('transactionid',   $data['formid']);
                    $this->db->bind('counter',         $icount);
                    $this->db->bind('defect_process_id',$defectid[$i]);
                    $this->db->bind('repair_counter',  $lastRepairData['counter']);
                    $this->db->bind('process_counter', $transactionData['counter']);
                    $this->db->bind('defect',          $defect[$i]);
                    $this->db->bind('location',        $location[$i]);
                    $this->db->bind('cause',           $cause[$i]);
                    $this->db->bind('action',          $raction[$i]);
                    $this->db->bind('remark',          $remark);
                    $this->db->bind('createdon',       date('Y-m-d'));
                    $this->db->bind('createdby',       $_SESSION['usr']['user']);
                    $this->db->execute();
                } 
        }
        // Insert New Transaction Process
        
        if($transactionData['lastprocess'] == 1 || $transactionData['lastprocess'] == 2){
            $query2 = "UPDATE t_ipd_process SET status=:status WHERE transactionid=:transactionid and counter=:counter";
            $this->db->query($query2);
            $this->db->bind('transactionid', $data['formid']);
            $this->db->bind('counter',       $transactionData['counter']);
            $this->db->bind('status',        'Closed');
            $this->db->execute();

            $query3 = "INSERT INTO t_ipd_process (transactionid,counter,status,process1,error_process,lastprocess) 
            VALUES(:transactionid,:counter,:status,:process1,:error_process,:lastprocess)";
            $this->db->query($query3);

            $this->db->bind('transactionid',  $data['formid']);
            $this->db->bind('counter',        $transactionData['counter']+1);
            $this->db->bind('status',         'Open');
            $this->db->bind('process1',       null);
            $this->db->bind('error_process',  null);
            $this->db->bind('lastprocess',    0);
	    //$this->db->bind('action',        $transactionData['action']);
            $this->db->execute();
        }else if($transactionData['lastprocess'] == 3 || $transactionData['lastprocess'] == 4){
            $query2 = "UPDATE t_ipd_process SET status=:status WHERE transactionid=:transactionid and counter=:counter";
            $this->db->query($query2);
            $this->db->bind('transactionid', $data['formid']);
            $this->db->bind('counter',       $transactionData['counter']);
            $this->db->bind('status',        'Closed');
            $this->db->execute();

            $query3 = "INSERT INTO t_ipd_process (transactionid,counter,status,process1,process2,process3,error_process,lastprocess) 
            VALUES(:transactionid,:counter,:status,:process1,:process2,:process3,:error_process,:lastprocess)";
            $this->db->query($query3);

            $this->db->bind('transactionid',  $data['formid']);
            $this->db->bind('counter',        $transactionData['counter']+1);
            $this->db->bind('status',         'Open');
            $this->db->bind('process1',       'Good');
            $this->db->bind('process2',       'Good');
            $this->db->bind('process3',       null);
            $this->db->bind('error_process',  null);
            $this->db->bind('lastprocess',    2);
	    //$this->db->bind('action',        $transactionData['action']);
            $this->db->execute();
        }else{
            if($data['status'] === "NOT PASS"){
                $repairData = $this->getRepairDataTransid($data['formid']);
                $closeRepair = "UPDATE t_ipd_repair SET status=:status WHERE transactionid=:transactionid and counter=:counter";
                
                $this->db->query($closeRepair);
                $this->db->bind('transactionid',      $data['formid']);
                $this->db->bind('counter',            $repairData['counter']);
                $this->db->bind('status',             'Closed');
                $this->db->execute();         
                
                
                //Insert New Repair Data
                // $insertNewRepair = "INSERT INTO t_ipd_repair (transactionid,counter,process_counter,status,defect_name,location,action) 
                //   VALUES(:transactionid,:counter,:process_counter,:status,:defect_name,:location,:action)";
                $insertNewRepair = "INSERT INTO t_ipd_repair (transactionid,counter,process_counter,status) 
                  VALUES(:transactionid,:counter,:process_counter,:status)";
                $this->db->query($insertNewRepair);

                $this->db->bind('transactionid',   $data['formid']);
                $this->db->bind('counter',         $repairData['counter']+1);
                $this->db->bind('process_counter', $transactionData['counter']);
                $this->db->bind('status',          'Open');
                // $this->db->bind('defect_name',   $repairData['defect_name']);
                // $this->db->bind('location',      $repairData['location']);
		        // $this->db->bind('action',        $repairData['action']);
                $this->db->execute();

                $defectid = $data['defectId'];
                $defect   = $data['defectItem'];                    
                $location = $data['locationItem'];
                $cause    = $data['causeItem'];
                $action   = $data['actionItem'];
                $raction  = $data['repairactionItem'];
                // $remark   = $data['remarkItem'];
                
                // $insertDefect = "UPDATE t_defect_process set repairaction=:repairaction, repairremark=:repairremark WHERE transactionid=:transactionid and id=:id";
                // $this->db->query($insertDefect);

                // for($i = 0; $i < sizeof($defect); $i++){
                //     $this->db->bind('transactionid', $data['formid']);
                //     $this->db->bind('id',            $defectid[$i]);
                //     $this->db->bind('repairaction',  $raction[$i]);
                //     $this->db->bind('repairremark',  $remark);
                //     $this->db->execute();
                // }   
                
                $insertDefectRepair = "INSERT INTO t_defect_repair (transactionid,counter,defect_process_id,repair_counter,process_counter,defect,location,cause,action,remark,createdby,createdon) VALUES(:transactionid,:counter,:defect_process_id,:repair_counter,:process_counter,:defect,:location,:cause,:action,:remark,:createdby,:createdon)";
                $this->db->query($insertDefectRepair);

                $icount = 0;
                for($i = 0; $i < sizeof($defect); $i++){
                    $icount = $icount + 1;
                    $this->db->bind('transactionid',    $data['formid']);
                    $this->db->bind('counter',          $icount);
                    $this->db->bind('defect_process_id',$defectid[$i]);
                    $this->db->bind('repair_counter',   $repairData['counter']+1);
                    $this->db->bind('process_counter',  $transactionData['counter']);
                    $this->db->bind('defect',           $defect[$i]);
                    $this->db->bind('location',         $location[$i]);
                    $this->db->bind('cause',            $cause[$i]);
                    $this->db->bind('action',           $raction[$i]);
                    $this->db->bind('remark',           $remark);
                    $this->db->bind('createdon',        date('Y-m-d'));
                    $this->db->bind('createdby',        $_SESSION['usr']['user']);
                    $this->db->execute();
                }   
            }
        }        

        return $this->db->rowCount();
    }
}
