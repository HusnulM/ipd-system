<?php

class Exportdata extends Controller{

    public function __construct(){
		if( isset($_SESSION['usr']) ){
			
		}else{
			header('location:'. BASEURL);
		}
    }
	public function exportransaction($strdate, $enddate){
		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['expdata']  = $this->model('Report_model')->rtransaction($strdate, $enddate);   

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("Trasaction Data")
             ->setSubject("Trasaction Data")
             ->setDescription("Trasaction Data")
             ->setKeywords("Trasaction Data");
		
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

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "NO"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "PROD DATE");
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "TEN NO");
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "MODEL");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "PART CODE");
		$excel->setActiveSheetIndex(0)->setCellValue('F1', "LOT CODE"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G1', "LOT / SERIAL NO"); 
		$excel->setActiveSheetIndex(0)->setCellValue('H1', "AOI SMT-BOTTOM (1st)"); 
		$excel->setActiveSheetIndex(0)->setCellValue('I1', "AOI SMT-TOP (2nd)");
        $excel->setActiveSheetIndex(0)->setCellValue('J1', "SMT SI");
		$excel->setActiveSheetIndex(0)->setCellValue('K1', "ICT");
		$excel->setActiveSheetIndex(0)->setCellValue('L1', "QPIT");
		$excel->setActiveSheetIndex(0)->setCellValue('M1', "AOI HW-TOP");
		$excel->setActiveSheetIndex(0)->setCellValue('N1', "AOI HW-BOTTOM");
		$excel->setActiveSheetIndex(0)->setCellValue('O1', "FVI");
		$excel->setActiveSheetIndex(0)->setCellValue('P1', "QQA");
		$excel->setActiveSheetIndex(0)->setCellValue('Q1', "Error Process");
		$excel->setActiveSheetIndex(0)->setCellValue('R1', "DEFECT NAME");
		$excel->setActiveSheetIndex(0)->setCellValue('S1', "LOCATION");
		$excel->setActiveSheetIndex(0)->setCellValue('T1', "CAUSE");
		$excel->setActiveSheetIndex(0)->setCellValue('U1', "ACTION");
		$excel->setActiveSheetIndex(0)->setCellValue('V1', "REPAIR-DEFECT");
		$excel->setActiveSheetIndex(0)->setCellValue('W1', "REPAIR-LOCATION");
		$excel->setActiveSheetIndex(0)->setCellValue('X1', "REPAIR-ACTION");
		$excel->setActiveSheetIndex(0)->setCellValue('Y1', "REPAIRER");
		$excel->setActiveSheetIndex(0)->setCellValue('Z1', "AFTER REPAIR-ICT");
		$excel->setActiveSheetIndex(0)->setCellValue('AA1', "AFTER REPAIR-QPIT");
		$excel->setActiveSheetIndex(0)->setCellValue('AB1', "AFTER REPAIR-AOI TOP");
		$excel->setActiveSheetIndex(0)->setCellValue('AC1', "AFTER REPAIR-BOT");
		$excel->setActiveSheetIndex(0)->setCellValue('AD1', "AFTER REPAIR-FVI");
		$excel->setActiveSheetIndex(0)->setCellValue('AE1', "QQA");		
		$excel->setActiveSheetIndex(0)->setCellValue('AF1', "QQA REMARK");												


		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('V1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('X1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('W1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Y1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Z1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AA1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AB1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AC1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AD1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AE1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AF1')->applyFromArray($style_col);
        // $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);

		
		$no = 1; 
		$numrow = 2;
		foreach($data['expdata'] as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['prod_date']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, '');
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $h['partmodel']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['partnumber']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $h['lotcode']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $h['serial_no']);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $h['process1']);
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $h['process2']);
            $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $h['process3']);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $h['process4']);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $h['process5']);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $h['process6']);
			$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $h['process7']);
			$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $h['process8']);
			$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $h['process9']);
			$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $h['error_process']);
			$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $h['process_defect']);
			$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $h['process_location']);
			$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $h['process_cause']);
			$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $h['process_action']);
			$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, $h['repair_defect']);
			$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, $h['repair_location']);
			$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, $h['repair_action']);
			$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, $h['repair1']);
			$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, $h['repair2']);
			$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, $h['repair3']);
			$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, $h['repair4']);
			$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, $h['repair5']);
			$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, $h['repair6']);
			$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, $h['repair7']);
			$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, $h['repair_remark']);
			
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
            $excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);

			$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('X'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('W'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Y'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('Z'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AA'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AB'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AC'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AD'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AE'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AF'.$numrow)->applyFromArray($style_row);
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Transaction Report");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="TransactionReport.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

	public function exportplanning($strdate, $enddate, $params){
		$url   = parse_url($_SERVER['REQUEST_URI']);
        $data  = parse_str($url['query'], $params);
        $model = $params['model'];

		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['expdata']  = $this->model('Production_model')->getPlanningByDate($strdate, $enddate, $model);

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("Planning Data")
             ->setSubject("Planning Data")
             ->setDescription("Planning Data")
             ->setKeywords("Planning Data");
		
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

		$style_cell_bgcolor_red = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'FF0000')
			)
		);

		$style_cell_bgcolor_green = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '80FF00')
			)
		);

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "NO"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "PLAN DATE");
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "LINE");
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "MODEL");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "LOT NUMBER");
		$excel->setActiveSheetIndex(0)->setCellValue('F1', "SHIFT");
		$excel->setActiveSheetIndex(0)->setCellValue('G1', "PLAN QTY"); 
		$excel->setActiveSheetIndex(0)->setCellValue('H1', "OUTPUT QTY");											


		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);

		
		$no = 1; 
		$numrow = 2;
		foreach($data['expdata'] as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['plandate']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['linename']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $h['model']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['lot_number']);
			if($h['shift'] == 1){
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, 'Day Shift');
			}else{
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, 'Night Shift');
			}
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $h['plan_qty']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $h['outputqty']);
			
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
			if($h['outputqty'] < $h['plan_qty']){
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_cell_bgcolor_red);
			}else{
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_cell_bgcolor_green);
			}
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Transaction Report");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Planning-Report.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}

	public function exportcriticalpart($strdate, $enddate){
		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['expdata']  = $this->model('Report_model')->rcriticalpart($strdate, $enddate);

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("Trasaction Data")
             ->setSubject("Trasaction Data")
             ->setDescription("Trasaction Data")
             ->setKeywords("Trasaction Data");
		
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

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "NO"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "SMT DATE");
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "AGEING TIME");
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "SMT SHIFT");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "SMT LINE");
		$excel->setActiveSheetIndex(0)->setCellValue('F1', "HANDWORK SHIFT"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G1', "HANDWORK LINE"); 
		$excel->setActiveSheetIndex(0)->setCellValue('H1', "MODEL"); 
		$excel->setActiveSheetIndex(0)->setCellValue('I1', "ASSY CODE");
        $excel->setActiveSheetIndex(0)->setCellValue('J1', "KEPI LOT");
		$excel->setActiveSheetIndex(0)->setCellValue('K1', "QUANTITY");
		$excel->setActiveSheetIndex(0)->setCellValue('L1', "DEFECT QTY");
		$excel->setActiveSheetIndex(0)->setCellValue('M1', "AGEING RESULT");
		$excel->setActiveSheetIndex(0)->setCellValue('N1', "AGEING REMARK");
		$excel->setActiveSheetIndex(0)->setCellValue('O1', "FT RESULT");
		$excel->setActiveSheetIndex(0)->setCellValue('P1', "DB1 PART LOT");
		$excel->setActiveSheetIndex(0)->setCellValue('Q1', "AGEING STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('R1', "FT STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('S1', "IC1 PART LOT");
		$excel->setActiveSheetIndex(0)->setCellValue('T1', "AGEING STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('U1', "FT STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('V1', "PC1 PART LOT");
		$excel->setActiveSheetIndex(0)->setCellValue('W1', "AGEING STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('X1', "FT STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('Y1', "D1 PART LOT");
		$excel->setActiveSheetIndex(0)->setCellValue('Z1', "AGEING STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('AA1', "FT STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('AB1', "D2 PART LOT");
		$excel->setActiveSheetIndex(0)->setCellValue('AC1', "AGEING STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('AD1', "FT STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('AE1', "T1 PART LOT");		
		$excel->setActiveSheetIndex(0)->setCellValue('AF1', "AGEING STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('AG1', "FT STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('AH1', "QF1 PART LOT");
		$excel->setActiveSheetIndex(0)->setCellValue('AI1', "AGEING STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('AJ1', "FT STATUS");												


		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('V1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('X1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('W1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Y1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Z1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AA1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AB1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AC1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AD1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AE1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AF1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AG1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AH1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AI1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AJ1')->applyFromArray($style_col);
		// $excel->getActiveSheet()->getStyle('AF1')->applyFromArray($style_col);
        // $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);

		
		$no = 1; 
		$numrow = 2;
		foreach($data['expdata'] as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['smt_date']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['ageing_time']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $h['smt_shift']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['smt_line']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $h['hw_shift']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $h['hw_line']);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $h['model']);
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $h['assy_code']);
            $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $h['kepi_lot']);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $h['ageing_qty']);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $h['defect_quantity']);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $h['ageing_result']);
			$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $h['failure_remark']);
			$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $h['ft_result']);
			if($h['location'] === 'DB1'){
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $h['part_lot']);
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $h['part_lot_ageing_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $h['part_lot_ft_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, '');
			}elseif($h['location'] === 'IC1'){
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $h['part_lot']);
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $h['part_lot_ageing_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $h['part_lot_ft_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, '');
			}elseif($h['location'] === 'PC1'){
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, $h['part_lot']);
				$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, $h['part_lot_ageing_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, $h['part_lot_ft_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, '');
			}elseif($h['location'] === 'D1'){
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, $h['part_lot']);
				$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, $h['part_lot_ageing_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, $h['part_lot_ft_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, '');
			}elseif($h['location'] === 'D2'){
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, $h['part_lot']);
				$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, $h['part_lot_ageing_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, $h['part_lot_ft_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, '');
			}elseif($h['location'] === 'T1'){
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, $h['part_lot']);
				$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, $h['part_lot_ageing_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, $h['part_lot_ft_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, '');
			}elseif($h['location'] === 'QF1'){
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, $h['part_lot']);
				$excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, $h['part_lot_ageing_result']);
				$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, $h['part_lot_ft_result']);
			}else{
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, '');
				$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, '');
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
			$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);

			$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('X'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('W'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Y'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('Z'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AA'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AB'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AC'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AD'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AE'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AF'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AG'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AH'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AI'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AJ'.$numrow)->applyFromArray($style_row);
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Transaction Report");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="CriticalPartReport.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
		
	}
}