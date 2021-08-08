<?php

class Laporan_model{
    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function getWhsAuth(){
        $user = $_SESSION['usr']['user'];
        $data = $this->db->query("SELECT * FROM t_user_object_auth WHERE username = '$user' and ob_auth = 'OB_WAREHOUSE' limit 1");
        return $this->db->single();
    }

    public function getStock($material = null, $warehouse = null, $zerostock)
    {
        $user = $_SESSION['usr']['user'];
        $whsAuth = $this->getWhsAuth();
        $query = "SELECT * FROM v_inventory01";

        $filterstock = "";
        if($zerostock === "Y"){
            $filterstock = "quantity >= 0";
        }else{
            $filterstock = "quantity > 0";
        }

        if(($material == "null" && $warehouse == "null") || ($material == null && $warehouse == null)){
            if($whsAuth['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_inventory01 WHERE $filterstock ORDER BY warehouse, material asc");
            }else{
                $this->db->query("SELECT * FROM v_inventory01 where warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE') AND $filterstock ORDER BY warehouse, material asc");
            }            
        }else if($material != null && ( $warehouse == null || $warehouse == "null" )){
            if($whsAuth['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_inventory01 WHERE material = '$material' AND $filterstock ORDER BY warehouse, material asc");
            }else{
                $this->db->query("SELECT * FROM v_inventory01 WHERE material = '$material' AND $filterstock and warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE') ORDER BY warehouse, material asc");
            } 
        }else if(($material == null || $material == "null" ) && ( $warehouse != null )){
            
            if($whsAuth['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_inventory01 WHERE warehouse = '$warehouse' AND $filterstock ORDER BY warehouse, material asc");
            }else{
                $this->db->query("SELECT * FROM v_inventory01 WHERE warehouse = '$warehouse' AND $filterstock and warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE') ORDER BY warehouse, material asc");
            }
        }else{
            $this->db->query("SELECT * FROM v_inventory01 WHERE material = '$material' AND $filterstock AND warehouse = '$warehouse' ORDER BY warehouse, material asc");
        }
        
		return $this->db->resultSet();
    }

    public function getBatchStock($material = null, $warehouse = null)
    {
        $user = $_SESSION['usr']['user'];
        $whsAuth = $this->getWhsAuth();

        // $query = "SELECT * FROM v_inventory01";

        if(($material == "null" && $warehouse == "null") || ($material == null && $warehouse == null)){
            if($whsAuth['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_stockbatch WHERE quantity > 0");
            }else{
                $this->db->query("SELECT * FROM v_stockbatch where warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE') and quantity > 0");
            }            
        }else if($material != null && $warehouse == null){
            if($whsAuth['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_stockbatch WHERE material = '$material' and quantity > 0");
            }else{
                $this->db->query("SELECT * FROM v_stockbatch WHERE material = '$material' and warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE') and quantity > 0");
            } 
        }else if(($material == null || $material == "null" ) && ( $warehouse != null )){
            
            if($whsAuth['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_stockbatch WHERE warehouse = '$warehouse' and quantity > 0");
            }else{
                $this->db->query("SELECT * FROM v_stockbatch WHERE warehouse = '$warehouse' and warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE') and quantity > 0");
            }
        }else{
            $this->db->query("SELECT * FROM v_stockbatch WHERE material = '$material' AND warehouse = '$warehouse' and quantity > 0");
        }
        
		return $this->db->resultSet();
    }

    public function getAllStock(){
        $this->db->query("SELECT * FROM v_totalstock");
        return $this->db->resultSet();
    }

    public function breakdownstock($matnr){
        $this->db->query("SELECT * FROM v_stock where material='$matnr'");
        return $this->db->resultSet();
    }

    public function getPR($strdate, $enddate, $status=null)
    {
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $ob_whs = $this->getWhsAuth();

        if($ob_whs['ob_value'] === "*"){
            $this->db->query("SELECT * FROM v_pr002 WHERE prdate BETWEEN '$strdate' AND '$enddate'");
            // if($status === "All" || $status === null){
            //     $this->db->query("SELECT * FROM v_pr002 WHERE prdate BETWEEN '$strdate' AND '$enddate'");
            // }elseif($status === "O"){
            //     $this->db->query("SELECT * FROM v_pr002 WHERE prdate BETWEEN '$strdate' AND '$enddate' and ");
            // }elseif($status === "A"){
            //     $this->db->query("SELECT * FROM v_pr002 WHERE prdate BETWEEN '$strdate' AND '$enddate'");
            // }elseif($status === "R"){
            //     $this->db->query("SELECT * FROM v_pr002 WHERE prdate BETWEEN '$strdate' AND '$enddate'");
            // }
        }else{
            $this->db->query("SELECT * FROM v_pr002 WHERE prdate BETWEEN '$strdate' AND '$enddate' and warehouse in(select ob_value from t_user_object_auth where username='$user')");
        }
        return $this->db->resultSet();        
    }

    public function getDataPO($strdate, $enddate)
    {
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $this->db->query("SELECT a.*, b.namavendor FROM t_po01 as a inner join t_vendor as b on a.vendor = b.vendor WHERE a.podat BETWEEN '$strdate' AND '$enddate'");
        return $this->db->resultSet();
    }

    public function getDataGR($strdate, $enddate)
    {
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $this->db->query("SELECT * FROM v_inventory03 WHERE movementdate BETWEEN '$strdate' AND '$enddate' and movement='101'");
		return $this->db->resultSet();
    }

    public function getMovementData($strdate, $enddate,$movement)
    {
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $ob_whs = $this->getWhsAuth();

        if($movement === 'All'){
            if($ob_whs['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_inventory03 WHERE movementdate BETWEEN '$strdate' AND '$enddate'");
            }else{
                $this->db->query("SELECT * FROM v_inventory03 WHERE movementdate BETWEEN '$strdate' AND '$enddate' and warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE')");
            }
        }elseif($movement === '1'){
            if($ob_whs['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_inventory03 WHERE movementdate BETWEEN '$strdate' AND '$enddate' AND movement in('101','561')");
            }else{
                $this->db->query("SELECT * FROM v_inventory03 WHERE movementdate BETWEEN '$strdate' AND '$enddate' AND movement in('101','561') and warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE')");
            }
        }else{
            if($ob_whs['ob_value'] === "*"){
                $this->db->query("SELECT * FROM v_inventory03 WHERE movementdate BETWEEN '$strdate' AND '$enddate' AND movement not in('101','561')");
            }else{
                $this->db->query("SELECT * FROM v_inventory03 WHERE movementdate BETWEEN '$strdate' AND '$enddate' AND movement not in('101','561') and warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_auth = 'OB_WAREHOUSE')");
            }
        }
		return $this->db->resultSet();
    }

    public function getReservasiData($strdate, $enddate)
    {
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $ob_whs = $this->getWhsAuth();
        if($ob_whs['ob_value'] === "*"){
            $this->db->query("SELECT * FROM v_reservasi01 WHERE resdate BETWEEN '$strdate' AND '$enddate' order by resnum desc");
        }else{
            $this->db->query("SELECT * FROM v_reservasi01 WHERE resdate BETWEEN '$strdate' AND '$enddate' and ( fromwhs in(select ob_value from t_user_object_auth where username='$user') OR towhs in(select ob_value from t_user_object_auth where username='$user')) order by resnum desc");
        }
		return $this->db->resultSet();
    }

    // header exeport PO
    public function getHeaderService($strdate,$enddate,$whs){
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $ob_whs = $this->getWhsAuth();

        if($whs === 'All'){
            if($ob_whs['ob_value'] === "*"){
                $this->db->query("SELECT a.*, b.deskripsi as 'whsname' FROM t_service01 as a left join t_gudang as b on a.warehouse = b.gudang WHERE a.servicedate BETWEEN '$strdate' AND '$enddate' order by servicenum asc");
            }else{
                $this->db->query("SELECT a.*, b.deskripsi as 'whsname' FROM t_service01 as a left join t_gudang as b on a.warehouse = b.gudang WHERE a.servicedate BETWEEN '$strdate' AND '$enddate' and a.warehouse in(select ob_value from t_user_object_auth where username='$user') order by servicenum asc");
            }
        }else{
            $this->db->query("SELECT a.*, b.deskripsi as 'whsname' FROM t_service01 as a left join t_gudang as b on a.warehouse = b.gudang WHERE a.servicedate BETWEEN '$strdate' AND '$enddate' and a.warehouse in(select ob_value from t_user_object_auth where username='$user' and ob_value='$whs') order by servicenum asc");
        }
		return $this->db->resultSet();
    }

    public function getDetailService($servicenum){
        $this->db->query("SELECT a.*, b.matdesc FROM t_service02 as a left join t_material as b on a.material = b.material WHERE a.servicenum = '$servicenum' order by a.servicenum, a.serviceitem asc");

        return $this->db->resultSet();
    }

    public function getHeaderServiceCost($strdate,$enddate){
        $this->db->query("SELECT * FROM v_service01 WHERE servicedate BETWEEN '$strdate' AND '$enddate' order by servicenum asc");

        return $this->db->resultSet();
    }

    public function getServiceCostItem($servicenum){
        $this->db->query("SELECT * FROM v_service02 WHERE servicenum = '$servicenum' order by servicenum, resitem asc");

        return $this->db->resultSet();
    }

    public function getHeaderInvoice($strdate,$enddate){
        $this->db->query("SELECT * FROM v_rinvoice01 WHERE ivdate BETWEEN '$strdate' AND '$enddate'");
        return $this->db->resultSet();
    }

    public function getDetailInvoice($ivnum){
        $this->db->query("SELECT * FROM v_rinvoice02 WHERE ivnum='$ivnum'");
        return $this->db->resultSet();
    }

    public function getExportCostReport($strdate,$enddate){
        $this->db->query("SELECT * FROM v_service02 WHERE servicedate BETWEEN '$strdate' AND '$enddate' order by servicenum, resitem asc");
        return $this->db->resultSet();
    }
}