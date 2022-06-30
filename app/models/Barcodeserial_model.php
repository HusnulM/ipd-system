<?php

class Barcodeserial_model{
    private $db;

    public function __construct()
    {
		$this->db = new Database;
    }

    public function getBarcodeDetails($barcode){
        $this->db->query("SELECT * FROM t_barcode_serial WHERE barcode_serial='$barcode'");
        return $this->db->single();
    }

    public function getBarcodeSerial(){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME."";
        $pdo = new PDO($dsn, DB_USER, DB_PASS);

        $host	= DB_HOST;
        $user	= DB_USER;
        $pass	= DB_PASS;
        $db	    = DB_NAME;

        $mysqli = new mysqli($host, $user, $pass, $db);

        $columns = array( 
            0 =>'barcode_serial', 
            1 =>'part_number',
            2=> 'part_lot',
        );

        $querycount = $mysqli->query("SELECT count(barcode_serial) as jumlah FROM t_barcode_serial");
        $datacount = $querycount->fetch_array();


        $totalData = $datacount['jumlah'];
            
        $totalFiltered = $totalData; 

        $limit = $_POST['length'];
        $start = $_POST['start'];
        $order = $columns[$_POST['order']['0']['column']];
        $dir = $_POST['order']['0']['dir'];
            
        if(empty($_POST['search']['value']))
        {            
            $query = $mysqli->query("SELECT barcode_serial,part_number,part_lot FROM t_barcode_serial order by $order $dir 
                                                                        LIMIT $limit 
                                                                        OFFSET $start");
        }
        else {
            $search = $_POST['search']['value']; 
            $query = $mysqli->query("SELECT barcode_serial,part_number,part_lot FROM t_barcode_serial WHERE barcode_serial LIKE '%$search%' 
                                                                        or part_number LIKE '%$search%' 
                                                                        order by $order $dir 
                                                                        LIMIT $limit 
                                                                        OFFSET $start");


        $querycount = $mysqli->query("SELECT count(barcode_serial) as jumlah FROM t_barcode_serial WHERE barcode_serial LIKE '%$search%' 
                                                                                            or part_number LIKE '%$search%'");
        $datacount = $querycount->fetch_array();
        $totalFiltered = $datacount['jumlah'];
        }

        $data = array();
        if(!empty($query))
        {
            $no = $start + 1;
            while ($r = $query->fetch_array())
            {
                $nestedData['no'] = $no;
                $nestedData['barcode_serial'] = $r['barcode_serial'];
                $nestedData['part_number'] = $r['part_number'];
                $nestedData['part_lot'] = $r['part_lot'];
                // $nestedData['part_lot'] = "<a href='#' class='btn-warning btn-sm'>Ubah</a>&nbsp; <a href='#' class='btn-danger btn-sm'>Hapus</a>";
                $data[] = $nestedData;
                $no++;
            }
        }
        
        $json_data = array(
                    "draw"            => intval($_POST['draw']),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        return $json_data; 
    }

    public function uploadBarcodeSerial($data){
        $nama_file_baru = 'data.xlsx';
				
        // Cek apakah terdapat file data.xlsx pada folder tmp
        if(is_file('tmp/'.$nama_file_baru)) // Jika file tersebut ada
            unlink('tmp/'.$nama_file_baru); // Hapus file tersebut
        
        $tipe_file = $_FILES['file']['type']; // Ambil tipe file yang akan diupload
        $tmp_file  = $_FILES['file']['tmp_name'];

        if($tipe_file == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
            move_uploaded_file($tmp_file, 'tmp/'.$nama_file_baru);
            
            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel   = $excelreader->load('tmp/'.$nama_file_baru);
            $sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
            $output = array();
            // var_dump($sheet);
            $numrow = 1;
            foreach($sheet as $row){
                // var_dump($row);
                $barcode    = $row['A']; 
				if(empty($barcode))
                    continue; 
                
                if($numrow > 1){                    
                    $excelData = array(
                        'barcode_serial'     => $row['A'] ?? '',
                        'part_number'        => $row['B'] ?? '',
                        'part_lot'           => $row['C'] ?? '',
                        'createdby'          => $_SESSION['usr']['user'],
                        'createdon'          => date('Y-m-d H:i:s')                        
                    );
                    array_push($output, $excelData);
                }
                $numrow++;
            }

            // echo json_encode($output);

            $query2 = Helpers::insertOrUpdate($output,'t_barcode_serial');
            $this->db->query($query2);
            $this->db->execute();
        }
    }
}