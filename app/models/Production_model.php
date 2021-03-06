<?php

class Production_model{

    private $db;

    public function __construct()
	{
		$this->db = new Database;
    }

    public function planningMonitoring(){
        $this->db->query("CALL sp_ProductionView()");
        return $this->db->resultSet();
    }

    public function planningMonitoringDay1(){
        $this->db->query("CALL sp_ProductionView1()");
        return $this->db->resultSet();
    }

    public function planningMonitoringDay2(){
        $this->db->query("CALL sp_ProductionView2()");
        return $this->db->resultSet();
    }

    public function planningMonitoringDay3(){
        $this->db->query("CALL sp_ProductionView3()");
        return $this->db->resultSet();
    }

    public function planningMonitoringDate(){
        $this->db->query("CALL sp_ProductionViewDate()");
        return $this->db->single();
    }

    public function getMaterialData($material){
        $this->db->query("SELECT * FROM t_material WHERE material='$material'");
        return $this->db->single();
    }

    public function getPlanningData($data){
        $plandate = $data['plandate'];
        $prodline = $data['prodline'];
        $shift    = $data['shift'];

        $this->db->query("SELECT a.*, b.description as 'linename', fGetProdTotalQtyOutput(a.plandate,a.productionline,a.shift,a.model,a.lot_number) as 'outputqty' FROM t_planning as a inner join t_production_lines as b on a.productionline = b.id WHERE a.plandate = '$plandate' AND a.productionline = '$prodline' AND a.shift = '$shift'");
		return $this->db->resultSet();
    }

    public function getPlanningByDate($strdate, $enddate, $model){
        if($model === "ALL"){
            $this->db->query("SELECT a.*, b.description as 'linename', fGetProdTotalQtyOutput(a.plandate,a.productionline,a.shift,a.model,a.lot_number) as 'outputqty' FROM t_planning as a inner join t_production_lines as b on a.productionline = b.id WHERE a.plandate BETWEEN '$strdate' AND '$enddate'");
            return $this->db->resultSet();
        }else{
            $this->db->query("SELECT a.*, b.description as 'linename', fGetProdTotalQtyOutput(a.plandate,a.productionline,a.shift,a.model,a.lot_number) as 'outputqty' FROM t_planning as a inner join t_production_lines as b on a.productionline = b.id WHERE a.plandate BETWEEN '$strdate' AND '$enddate' AND a.model ='$model'");
            return $this->db->resultSet();
        }
    }

    public function getActualData($data){
        $plandate = $data['plandate'];
        $prodline = $data['prodline'];
        $shift    = $data['shift'];
        $model    = $data['model'];

        $this->db->query("SELECT a.*, b.description as 'linename' FROM t_planning_output as a inner join t_production_lines as b on a.productionline = b.id WHERE a.plandate = '$plandate' AND a.productionline = '$prodline' AND a.shift = '$shift' AND a.model = '$model'");
		return $this->db->resultSet();
    }

    public function searchMaterial($params)
    {
        $this->db->query("SELECT * FROM t_material WHERE matdesc like '%$params%'");
		return $this->db->resultSet();
    }

    public function saveactualdata($data){
        $currentDate = date('Y-m-d');
        $dataToInsert = array();

        $materialdata = $this->getMaterialData($data['model']);

        $insertData = array(
            "plandate"       => $data['plandate'],
            "productionline" => $data['prodline'],
            "shift"          => $data['shift'],
            "model"          => $data['model'],
            "partnumber"     => $materialdata['material'],
            "lot_number"     => $data['lot_number'],
            "output_qty"     => $data['quantity'],
            "createdon"      => date('Y-m-d'),
            "createdby"      => $_SESSION['usr']['user']
        );

        array_push($dataToInsert, $insertData);

        $query2 = Helpers::insertOrUpdate($dataToInsert,'t_planning_output');
        $this->db->query($query2);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function  savePlanning($data){
        // echo json_encode($data);
        $currentDate = date('Y-m-d');
        $model    = $data['model'];
        $lotnumber= $data['lotnumber'];
        $quantity = $data['inputqty'];
        $inputqty = 0;
        $dataToInsert = array();
        for($i = 0; $i < sizeof($model); $i++){

            $materialdata = $this->getMaterialData($model[$i]);
            if($quantity[$i] <= 0){
                $inputqty = 0;
            }else{
                $inputqty = $quantity[$i];
            }
            $insertData = array(
                "plandate"       => $data['plandate'],
                "productionline" => $data['prodline'],
                "shift"          => $data['shift'],
                "model"          => $materialdata['matdesc'],
                "partnumber"     => $model[$i],
                "lot_number"     => $lotnumber[$i],
                "plan_qty"       => $inputqty,
                "createdon"      => date('Y-m-d'),
                "createdby"      => $_SESSION['usr']['user']
            );

            array_push($dataToInsert, $insertData);
        }

        $query2 = Helpers::insertOrUpdate($dataToInsert,'t_planning');
        $this->db->query($query2);
        $this->db->execute();
        return $this->db->rowCount();

        // $query = "INSERT INTO t_planning (plandate,productionline,shift,model,plan_qty,createdon,createdby) 
        //               VALUES(:plandate,:productionline,:shift,:model,:plan_qty,:createdon,:createdby)";
        // $this->db->query($query);
        
        // $this->db->bind('plandate',       $data['menugroup']);
        // $this->db->bind('productionline', $data['groupindex']);
        // $this->db->bind('shift',          $data['groupindex']);
        // $this->db->bind('model',          $data['groupindex']);
        // $this->db->bind('plan_qty',       $data['groupindex']);
        // $this->db->bind('createdon',      $currentDate);
        // $this->db->bind('createdby',      $_SESSION['usr']['user']);
        // $this->db->execute();

        // return $this->db->rowCount();
    }

    public function update($data){
        $query = "UPDATE t_menugroups set description=:description, _index=:_index WHERE menugroup=:menugroup";
        $this->db->query($query);

        $this->db->bind('menugroup',   $data['idgroup']);
        $this->db->bind('description', $data['menugroup']);
        $this->db->bind('_index',      $data['groupindex']);
        $this->db->execute();

        return $this->db->rowCount();        
    }

    public function delete($id){
        $query = "DELETE FROM t_menugroups WHERE menugroup=:menugroup";
        $this->db->query($query);

        $this->db->bind('menugroup',   $id);
        $this->db->execute();

        return $this->db->rowCount();        
    }
}