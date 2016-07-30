<?php
	require_once('../module/pdf/mpdf.php');
	require_once('../MysqliDb.php') ;

	DEFINE('DB_HOST','localhost');
	DEFINE('DB_USER','root');
	DEFINE('DB_PASSWORD','tangoalpha77151');
	DEFINE('DB_NAME','wiki_look');
	DEFINE('TABLE_EXPENSES_FOLDER','expenses_folder');
	DEFINE('TABLE_EXPENSES_ENTRY','expenses_entry');

	$html = "";

	$conn = new Mysqlidb (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$folder_id = 1;
	$conn->where("expenses_id",$folder_id);
	$folder = $conn->get(TABLE_EXPENSES_FOLDER); 

	$folder_name = $folder[0]['expenses_folder_name'];

	$html .= "<h2 align='center'>".$folder_name ."</h2>";

	$conn->where("fk_folder_id",$folder_id);
	$entries = $conn->get(TABLE_EXPENSES_ENTRY);

	$html .= '<table border="1" style="border-collapse:collapse;"><thead><tr><th style="text-align:center;width:300px;padding:12px;">Reason of Expenditure</th><th style="text-align:center;width:250px;">Date of Expenditure</th><th style="text-align:center;width:130px;">Amount</th></tr></thead><tbody>';

	$GMT_Conversion = 19800;
	foreach($entries as $entry){
		$epoch = $entry['expenses_insert_time'] + $GMT_Conversion;
		$insert_time = (new DateTime("@$epoch"))->format('F jS, Y');

		$html .= '<tr><td style="padding:10px;">'.$entry['expenses_reason'].'</td><td style="text-align:center;">'.$insert_time.'</td><td style="text-align:center;">'.$entry['expenses_amount'].'</td></tr>';
	}

	$html .= '</tbody></table>';

	$mpdf=new mPDF(); 

	$mpdf->WriteHTML($html);
	$mpdf->Output();
	exit;
?>