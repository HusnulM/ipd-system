<?php 
require_once 'app/init.php';

$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME."";
$pdo = new PDO($dsn, DB_USER, DB_PASS);

$host	= DB_HOST;
$user	= DB_USER;
$pass	= DB_PASS;
$db	    = DB_NAME;

//Menggunakan objek mysqli untuk membuat koneksi dan menyimpan nya dalam variabel $mysqli	
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
    
echo json_encode($json_data); 