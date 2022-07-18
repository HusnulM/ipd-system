<?php

class Handworkprocess_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function checkKepi($kepi, $assycode){
        $this->db->query("SELECT * FROM t_handwork_process WHERE kepi_lot='$kepi' AND assy_code<>'$assycode'");
        return $this->db->single();
    }

    public function getKepi($kepi){
        $this->db->query("SELECT * FROM t_handwork_process WHERE kepi_lot='$kepi'");
        return $this->db->single();
    }

    public function checkKepiExists($kepi, $assycode){
        $this->db->query("SELECT * FROM t_handwork_process WHERE kepi_lot='$kepi' AND assy_code='$assycode'");
        return $this->db->single();
    }

    public function checkKepiqrcode($kepi, $qrcode){
        $this->db->query("SELECT * FROM t_handwork_process_items WHERE kepi_lot='$kepi' AND barcode_serial='$qrcode'");
        return $this->db->single();
    }

    public function save($data){
        $kepiCheck = $this->checkKepiExists($data['kepilot'],$data['assycode']);
        if($kepiCheck){
            $query = "INSERT INTO t_handwork_process_items (kepi_lot, assy_code, barcode_serial, part_lot, createdby, createdon) VALUES (:kepi_lot, :assy_code, :barcode_serial, :part_lot, :createdby, :createdon)";
            $this->db->query($query);
    
            $this->db->bind('assy_code', $data['assycode']);
            $this->db->bind('kepi_lot',  $data['kepilot']);
            $this->db->bind('barcode_serial',  $data['barcode']);
            $this->db->bind('part_lot',  $data['lotnumber']);
            $this->db->bind('createdby', $_SESSION['usr']['user']);
            $this->db->bind('createdon', date('Y-m-d H:m:s'));
            $this->db->execute();
        }else{
            $query = "INSERT INTO t_handwork_process (assy_code, kepi_lot, hw_line, hw_shift, createdby, createdon) VALUES (:assy_code, :kepi_lot, :hw_line, :hw_shift, :createdby, :createdon)";
            $this->db->query($query);
    
            $this->db->bind('assy_code', $data['assycode']);
            $this->db->bind('kepi_lot',  $data['kepilot']);
            $this->db->bind('hw_line',   $data['hwline'] ?? null);
            $this->db->bind('hw_shift',  $data['hwshift'] ?? null);
            $this->db->bind('createdby', $_SESSION['usr']['user']);
            $this->db->bind('createdon', date('Y-m-d H:m:s'));
            $this->db->execute();

            $query2 = "INSERT INTO t_handwork_process_items (kepi_lot, assy_code, barcode_serial, part_lot, createdby, createdon) VALUES (:kepi_lot, :assy_code, :barcode_serial, :part_lot, :createdby, :createdon)";
            $this->db->query($query2);
    
            $this->db->bind('assy_code', $data['assycode']);
            $this->db->bind('kepi_lot',  $data['kepilot']);
            $this->db->bind('barcode_serial',  $data['barcode']);
            $this->db->bind('part_lot',  $data['lotnumber']);
            $this->db->bind('createdby', $_SESSION['usr']['user']);
            $this->db->bind('createdon', date('Y-m-d H:m:s'));
            $this->db->execute();
        }

        return $this->db->rowCount();
    }
}