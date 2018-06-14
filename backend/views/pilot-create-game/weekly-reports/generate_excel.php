<?php

$company = \backend\models\Company::find()->where(['id' => $comp_id])->one();
$comp_name = str_replace(' ', '-', strtolower($company->company_name));
$challenge_name = str_replace(' ', '-', strtolower($challenge_obj->challenge_name));
$company_logo = '/backend/web/img/uploads/' . $company->image;
$game_start = date('F Y', $game_obj->challenge_start_date);
$week_title = 'All Users - Week' . $week . ' - ' . $game_start;

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
//Define Format of Excel Sheet
$style_bold = [
  'font' => [
    'bold' => true,
  ],
];
$style_align = [
  'alignment' => [
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  ]
];
$style_border = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
    ),
  ),
);
$objPHPExcel->setActiveSheetIndex(0);
//Merge Cells for Logo Display
$objPHPExcel->getActiveSheet()->mergeCells('A1:N4');
/* ADD LOGO */
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath($_SERVER["DOCUMENT_ROOT"] . $company_logo);
$objDrawing->setCoordinates('A1');
// set resize to false first
$objDrawing->setResizeProportional(false);
// set width later
$objDrawing->setWidth(100);
$objDrawing->setHeight(80);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
//$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
/* END LOGO */

//Merge Cells for Challenge Name
$objPHPExcel->getActiveSheet()->mergeCells('A5:N6');
//Challenge Name Display
$objPHPExcel->getActiveSheet()->setCellValue('A5', ucwords($challenge_obj->challenge_name));
//Merge Cells for Week Title
$objPHPExcel->getActiveSheet()->mergeCells('A7:N8');
//Week Title Display
$objPHPExcel->getActiveSheet()->setCellValue('A7', $week_title);

//Columns Header
$objPHPExcel->getActiveSheet()->setCellValue('A9', "#")
    ->setCellValue('B9', "First Name")
    ->setCellValue('C9', "Last Name")
    ->setCellValue('D9', "Email Id")
    ->setCellValue('E9', "Daily Inspiration")
    ->setCellValue('F9', "Core Value")
    ->setCellValue('G9', "Check in with yourself")
    ->setCellValue('H9', "Shout Out")
    ->setCellValue('I9', "Leadership Corner")
    ->setCellValue('J9', "Weekly Video")
    ->setCellValue('K9', "Share A Win")
    ->setCellValue('L9', "Steps")
    ->setCellValue('M9', "Overall Points")
    ->setCellValue('N9', "Raffle Tickets");

// Add data
$i = 10;
$sno = 1;
foreach ($user_arr as $user):
  $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sno)
      ->setCellValue('B' . $i, $user["firstname"])
      ->setCellValue('C' . $i, $user["lastname"])
      ->setCellValue('D' . $i, $user["email"])
      ->setCellValue('E' . $i, $user["daily_actions"])
      ->setCellValue('F' . $i, $user["core_values"])
      ->setCellValue('G' . $i, $user["check_in"])
      ->setCellValue('H' . $i, $user["shout_out"])
      ->setCellValue('I' . $i, $user["leadership_corner"])
      ->setCellValue('J' . $i, $user["weekly_video"])
      ->setCellValue('K' . $i, $user["share_a_wins"])
      ->setCellValue('L' . $i, $user["total_steps"])
      ->setCellValue('M' . $i, $user["total_points"])
      ->setCellValue('N' . $i, $user["raffle_ticket"]);
  $i++;
  $sno++;
endforeach;

//Wrap Text
$objPHPExcel->getDefaultStyle()->applyFromArray($style_align)->getAlignment()->setWrapText(true);
//Bold Text & Font Size
$objPHPExcel->getActiveSheet()->getStyle('A5:N6')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A5:N6')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getStyle('A7:N8')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A9:N9')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A9:N9')->getFont()->setSize(12);
//Border
$lastcell = $i - 1;
$objPHPExcel->getActiveSheet()->getStyle('A1:N' . $lastcell)->applyFromArray($style_border);
//Setting Width of Columns
$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
//Setting Height of Rows
$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(15);
$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(15);
$objPHPExcel->getActiveSheet()->getRowDimension(9)->setRowHeight(40);
for ($j = 10; $j <= $lastcell; $j++):
  $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(30);
endfor;

// Rename worksheet

$objPHPExcel->getActiveSheet()->setTitle('Weekly Report');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//Report Name
$file_name = ucfirst($comp_name) . '_Week' . $week . '_' . $challenge_name . '.xls';

// Redirect output to a client web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $file_name);
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>
