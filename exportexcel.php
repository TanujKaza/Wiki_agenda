<?php
	require_once('../module/PHPExcel/Classes/PHPExcel.php') ;
	require_once('include/common.php') ;

	$filename = "Expenditure";

	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
	header("Cache-Control: max-age=0");

	$excel = new PHPExcel();
	$folder_id = 1;

	$conn->where("expenses_id",$folder_id);
	$folder = $conn->get(TABLE_EXPENSES_FOLDER);

	$objWorkSheet = $excel->createSheet(0)->setTitle($folder[0]['expenses_folder_name']);

	function export_data($folder_id){
		$GLOBALS['conn']->where("fk_folder_id",$folder_id);
		$entries = $GLOBALS['conn']->get(TABLE_EXPENSES_ENTRY);

		$styleArray = array(
		    'font'  => array(
		        'size'  => 10,
		        'name'  => 'Frutiger LT 45 Light'
		    ));

		$GLOBALS['excel']->setActiveSheetIndex(0) ;
		$sheet = $GLOBALS['excel']->getActiveSheet() ;

		$sheet->setCellValue("A1", "Reason")->setCellValue("B1","Date of Expenditure")->setCellValue("C1","Amount");
		$sheet->getColumnDimension("A")->setWidth(55);
		$sheet->getColumnDimension("B")->setWidth(21);
		$sheet->getColumnDimension("C")->setWidth(50);

		$BStyle = array(
			  'borders' => array(
			    'allborders' => array(
			      'style' => PHPExcel_Style_Border::BORDER_THIN 
			    )
			  )
			);

		$sheet->getDefaultStyle()->applyFromArray($BStyle);
		$sheet->getDefaultStyle()->applyFromArray($styleArray);

		$sheet->getStyle('A1:C1')->getFont()->setBold(true);
		$sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$row = 2;
		$GMT_Conversion = 19800;
		foreach($entries as $entry){
			$epoch = $entry['expenses_insert_time'] + $GMT_Conversion;
			$insert_time = (new DateTime("@$epoch"))->format('F jS, Y');

			$sheet->setCellValue("A".$row,$entry['expenses_reason'])->setCellValue("B".$row,$insert_time)->setCellValue("C".$row,$entry['expenses_amount']);
			$sheet->getStyle("C".$row)->getAlignment()->setWrapText(true);
			$sheet->getStyle("C".$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$row++;
		}
	}

	export_data($folder_id);

	$excel->setActiveSheetIndex(0) ;
	$excel->removeSheetByIndex(1);

	$objWriter = PHPExcel_IOFactory::createWriter($excel, "Excel5");
	$objWriter->save("php://output");

	exit;
?>