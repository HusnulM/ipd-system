<?php

class Exportdata extends Controller{

    public function __construct(){
		if( isset($_SESSION['usr']) ){
			
		}else{
			header('location:'. BASEURL);
		}
    }
	public function exportbatchstock($material = null, $warehouse = null){
		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['expdata']  = $this->model('Laporan_model')->getBatchStock($material,$warehouse);   
		// echo json_encode($data['expdata']);

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("Stock Data")
             ->setSubject("Stock Data")
             ->setDescription("Stock Data")
             ->setKeywords("Stock Data");
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_aligment_left = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			)
		);

		// Header		
		$excel->setActiveSheetIndex(0)->setCellValue('A1', $data['setting']['company']);
		$excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Laporan Batch Stock"); 
		$excel->getActiveSheet()->mergeCells('A2:G2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A4', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "Kode Barang"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C4', "Nama Barang"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D4', "Batch Number"); 
		$excel->setActiveSheetIndex(0)->setCellValue('E4', "Warehouse"); 
		$excel->setActiveSheetIndex(0)->setCellValue('F4', "Quantity");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', "Satuan");

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        // $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);

		// Set height baris ke 1, 2 dan 3
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		// Buat query untuk menampilkan semua data siswa
		
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($data['expdata'] as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['material']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['matdesc']);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $h['batch']);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['warehouse']. " - ". $h['whsname']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $h['quantity']);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $h['matunit']);
			
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            // $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
			
			$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Report Stock");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Report-Batch-Stock.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

	public function exportstock($material = null, $warehouse = null, $zerostock){
        $data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['expdata']  = $this->model('Laporan_model')->getStock($material, $warehouse, $zerostock);

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("Stock Data")
             ->setSubject("Stock Data")
             ->setDescription("Stock Data")
             ->setKeywords("Stock Data");
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_aligment_left = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			)
		);

		// Header		
		$excel->setActiveSheetIndex(0)->setCellValue('A1', $data['setting']['company']);
		$excel->getActiveSheet()->mergeCells('A1:H1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Laporan Stock"); 
		$excel->getActiveSheet()->mergeCells('A2:H2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A4', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "Kode Barang"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C4', "Nama Barang"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D4', "Part Name"); 
		$excel->setActiveSheetIndex(0)->setCellValue('E4', "Part Number"); 
		$excel->setActiveSheetIndex(0)->setCellValue('F4', "Warehouse"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G4', "Quantity");
        $excel->setActiveSheetIndex(0)->setCellValue('H4', "Satuan");

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);

		// Set height baris ke 1, 2 dan 3
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		// Buat query untuk menampilkan semua data siswa
		
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($data['expdata'] as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['material']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['matdesc']);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $h['partname']);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['partnumber']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $h['warehouse']. " - ". $h['deskripsi']);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $h['quantity']);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $h['matunit']);
			
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
			
			$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Report Stock");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Report-Stock.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
    }

    public function exportservice($strdate,$enddate){
		// $url = parse_url($_SERVER['REQUEST_URI']);
        // $data = parse_str($url['query'], $params);
		// $ponum = $params['ponum'];

		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['service']  = $this->model('Service_model')->getExportService($strdate,$enddate);

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("Service Data")
             ->setSubject("Service Data")
             ->setDescription("Service Data")
             ->setKeywords("Service Data");
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_aligment_left = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			)
		);

		// Header		
		$excel->setActiveSheetIndex(0)->setCellValue('A1', $data['setting']['company']);
		$excel->getActiveSheet()->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Data Service Periode ". $strdate . " s/d ". $enddate); 
		$excel->getActiveSheet()->mergeCells('A2:L2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		// $objDrawing = new PHPExcel_Worksheet_Drawing();
        // $objDrawing->setName('Logo ');
        // $objDrawing->setDescription('Logo ');
        // $objDrawing->setPath('./images/aws-logo.png');
        // $objDrawing->setResizeProportional(true);
        // $objDrawing->setWidth(100);
        // $objDrawing->setCoordinates('G1');
        // $objDrawing->setWorksheet($excel->getActiveSheet());

		// $excel->setActiveSheetIndex(0)->setCellValue('B5', "Purchase Order");
		// $excel->setActiveSheetIndex(0)->setCellValue('C5', $data['header']['ponum'],PHPExcel_Cell_DataType::TYPE_STRING);
		// $excel->setActiveSheetIndex(0)->setCellValue('F5', "PO Note");
		// $excel->setActiveSheetIndex(0)->setCellValue('G5', $data['header']['note']);

		// $excel->setActiveSheetIndex(0)->setCellValue('B6', "Vendor");
		// $excel->setActiveSheetIndex(0)->setCellValue('C6', $data['header']['namavendor']);
		// $excel->setActiveSheetIndex(0)->setCellValue('F6', "PO Date");
		// $excel->setActiveSheetIndex(0)->setCellValue('G6', $data['header']['podat']);

		// $excel->setActiveSheetIndex(0)->setCellValue('B7', "Alamat Vendor");
		// $excel->setActiveSheetIndex(0)->setCellValue('C7', $data['header']['alamat']);
		// $excel->setActiveSheetIndex(0)->setCellValue('F7', "Created Date");
		// $excel->setActiveSheetIndex(0)->setCellValue('G7', $data['header']['createdon']);

		// $excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE);
		// $excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE);
		// $excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE);
		// $excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE);

		// $excel->getActiveSheet()->getStyle('B6')->getFont()->setBold(TRUE);
		// $excel->getActiveSheet()->getStyle('C6')->getFont()->setBold(TRUE);
		// $excel->getActiveSheet()->getStyle('F6')->getFont()->setBold(TRUE);
		// $excel->getActiveSheet()->getStyle('G6')->getFont()->setBold(TRUE);

		// $excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(TRUE);
		// $excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);
		// $excel->getActiveSheet()->getStyle('F7')->getFont()->setBold(TRUE);
		// $excel->getActiveSheet()->getStyle('G7')->getFont()->setBold(TRUE);

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A4', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "Nomor Service"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C4', "Tanggal Service"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D4', "Note"); 
		$excel->setActiveSheetIndex(0)->setCellValue('E4', "Mekanik"); 
		$excel->setActiveSheetIndex(0)->setCellValue('F4', "No. Polisi Kendaraan"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G4', "Warehouse");
        $excel->setActiveSheetIndex(0)->setCellValue('H4', "Kode Barang");
        $excel->setActiveSheetIndex(0)->setCellValue('I4', "Nama Barang");
        $excel->setActiveSheetIndex(0)->setCellValue('J4', "Quantity");
        $excel->setActiveSheetIndex(0)->setCellValue('K4', "Satuan");
        $excel->setActiveSheetIndex(0)->setCellValue('L4', "Status"); 
		// $excel->setActiveSheetIndex(0)->setCellValue('H8', "Item Remark"); 

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col); 
        $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);
		// $excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);

		// Set height baris ke 1, 2 dan 3
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		// Buat query untuk menampilkan semua data siswa
		
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($data['service'] as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['servicenum']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['servicedate']);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $h['note']);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['mekanik']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $h['nopol']);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $h['whsname']);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $h['material']);
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $h['matdesc']);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $h['quantity']);	
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $h['unit']);	
            if($h['servicestatus'] === 'X'){
                $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, 'Confirmed');	
            }else{
                $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, 'Open');	
            }
			
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
			// $excel->getActiveSheet()->getStyle('F'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			// $excel->getActiveSheet()->getStyle('G'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Data Service");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data-Service.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}

    public function exportmovement($strdate,$enddate,$movement){
        $data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['expdata']  = $this->model('Laporan_model')->getMovementData($strdate, $enddate, $movement);

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("Service Data")
             ->setSubject("Service Data")
             ->setDescription("Service Data")
             ->setKeywords("Service Data");
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_aligment_left = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			)
		);

		// Header		
		$excel->setActiveSheetIndex(0)->setCellValue('A1', $data['setting']['company']);
		$excel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Laporan Pergerakan Inventory Periode ". $strdate . " s/d ". $enddate); 
		$excel->getActiveSheet()->mergeCells('A2:N2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A4', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "Movement Number"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C4', "Movement Item"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D4', "Movement Type"); 
		$excel->setActiveSheetIndex(0)->setCellValue('E4', "Movement Date"); 
		$excel->setActiveSheetIndex(0)->setCellValue('F4', "Note"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G4', "Warehouse");
        $excel->setActiveSheetIndex(0)->setCellValue('H4', "Kode Barang");
        $excel->setActiveSheetIndex(0)->setCellValue('I4', "Nama Barang");
        $excel->setActiveSheetIndex(0)->setCellValue('J4', "Quantity");
        $excel->setActiveSheetIndex(0)->setCellValue('K4', "Unit");
        $excel->setActiveSheetIndex(0)->setCellValue('L4', "Batch Number"); 
        $excel->setActiveSheetIndex(0)->setCellValue('M4', "Refrence Number"); 
        $excel->setActiveSheetIndex(0)->setCellValue('N4', "Refrence Item"); 
		// $excel->setActiveSheetIndex(0)->setCellValue('H8', "Item Remark"); 

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col); 
        $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N4')->applyFromArray($style_col);
		// $excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);

		// Set height baris ke 1, 2 dan 3
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		// Buat query untuk menampilkan semua data siswa
		
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($data['expdata'] as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['grnum']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['gritem']);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $h['movement']. ' - '. $h['movemventtext']);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['movementdate']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $h['note']);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $h['whsname']);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $h['material']);
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $h['matdesc']);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $h['quantity']);	
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $h['unit']);	
            $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $h['batchnumber']);	

            if($h['movement'] === '101'){
                $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $h['ponum']);	
                $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $h['poitem']);	
            }else{
                $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $h['resnum']);	
                $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $h['resitem']);	
            }


			
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
			
			$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Data Inventory");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data-Inventory.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
    }

    public function exportcostreport($strdate, $enddate){
        $data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['expdata']  = $this->model('Laporan_model')->getExportCostReport($strdate, $enddate);

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("Report Cost")
             ->setSubject("Report Cost")
             ->setDescription("Report Cost")
             ->setKeywords("Report Cost");
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_aligment_left = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			)
		);

		// Header		
		$excel->setActiveSheetIndex(0)->setCellValue('A1', $data['setting']['company']);
		$excel->getActiveSheet()->mergeCells('A1:O1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Laporan Cost Service Periode ". $strdate . " s/d ". $enddate); 
		$excel->getActiveSheet()->mergeCells('A2:O2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A4', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "Service Number"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C4', "Service Item"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D4', "Tanggal Service"); 
		$excel->setActiveSheetIndex(0)->setCellValue('E4', "Note"); 
		$excel->setActiveSheetIndex(0)->setCellValue('F4', "Mekanik"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G4', "No. Polisi");
        $excel->setActiveSheetIndex(0)->setCellValue('H4', "Warehouse");
        $excel->setActiveSheetIndex(0)->setCellValue('I4', "Kode Barang");
        $excel->setActiveSheetIndex(0)->setCellValue('J4', "Nama Barang");
        $excel->setActiveSheetIndex(0)->setCellValue('K4', "Batch Number");
        $excel->setActiveSheetIndex(0)->setCellValue('L4', "Quantity"); 
        $excel->setActiveSheetIndex(0)->setCellValue('M4', "Unit"); 
        $excel->setActiveSheetIndex(0)->setCellValue('N4', "Unit Price");
        $excel->setActiveSheetIndex(0)->setCellValue('O4', "Total Price"); 

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col); 
        $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O4')->applyFromArray($style_col);

		// Set height baris ke 1, 2 dan 3
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($data['expdata'] as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['servicenum']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['resitem']);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $h['servicedate']);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['note']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $h['mekanik']);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $h['nopol']);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $h['whsname']);
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $h['material']);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $h['matdesc']);	
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $h['batchnumber']);	
            $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $h['quantity']);	
            $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $h['unit']);	
            $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $h['price']);
            $excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $h['subtotal']);
			
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
			
			$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Report Cost");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Report-Cost.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
    }
}