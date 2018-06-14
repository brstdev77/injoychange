<?php
$company = \backend\models\Company::find()->where(['id' => $comp_id])->one();
$comp_name = str_replace(' ', '-', strtolower($company->company_name));
$game = $gamemodel->challenge_id;
$challenge_name = \backend\models\PilotCreateGame::getbannertext($gamemodel->id);
$challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game])->one();
//$challenge_name = str_replace(' ', '-', strtolower($challenge_obj->challenge_name));
$company_logo = '/backend/web/img/uploads/' . $company->image;
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
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);
$objPHPExcel->setActiveSheetIndex(0);
//Merge Cells for Logo Display
$objPHPExcel->getActiveSheet()->mergeCells('A1:Q4');
/* ADD LOGO */
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath($_SERVER["DOCUMENT_ROOT"] . $company_logo);
$objDrawing->setCoordinates('A1');
// set resize to false first
$objDrawing->setResizeProportional(false);
// set width later
$objDrawing->setWidth(260);
$objDrawing->setHeight(55);
$objDrawing->setOffsetX(20);
$objDrawing->setOffsetY(20);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
//$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
/* END LOGO */
$objPHPExcel->getActiveSheet()->mergeCells('A5:Q6');
//Challenge Name Display
$objPHPExcel->getActiveSheet()->setCellValue('A5', ucwords($challenge_name));
//Merge Cells for Challenge Name
$objPHPExcel->getActiveSheet()->mergeCells('A7:Q8');
//Challenge Name Display
$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Digital High Five Report');

foreach ($data as $data_name):
    $objPHPExcel->getActiveSheet()->setCellValue('A9', 'S.No.');
    $objPHPExcel->getActiveSheet()->mergeCells('B9:D9');
    $objPHPExcel->getActiveSheet()->setCellValue('B9', $data_name[0]);
    $objPHPExcel->getActiveSheet()->mergeCells('E9:G9');
    $objPHPExcel->getActiveSheet()->setCellValue('E9', $data_name[1]);
    $objPHPExcel->getActiveSheet()->mergeCells('H9:I9');
    $objPHPExcel->getActiveSheet()->setCellValue('H9', $data_name[2]);
     $objPHPExcel->getActiveSheet()->mergeCells('J9:K9');
    $objPHPExcel->getActiveSheet()->setCellValue('J9', $data_name[3]);
    $objPHPExcel->getActiveSheet()->mergeCells('L9:Q9');
    $objPHPExcel->getActiveSheet()->setCellValue('L9', $data_name[4]);
    /*$objPHPExcel->getActiveSheet()->setCellValue('A7', $data_name[0])
           ->setCellValue('B7', $data_name[1]);*/
//    $objPHPExcel->getActiveSheet()->mergeCells('C7:N7');
//    $objPHPExcel->getActiveSheet()->setCellValue('C7', $data_name[2]);
endforeach;
// Add data
 $sno =1;
$i = 10;
foreach ($dataxls as $data):
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sno);
    $objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':D'.$i);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, ucwords($data['username']));
    $objPHPExcel->getActiveSheet()->mergeCells('E'.$i.':G'.$i);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $data['emailaddress']);
    $objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':I'.$i);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $data['date']);
    $objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':K'.$i);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $data['time']);
    $string = remove_emoji($data['comment']);
    $objPHPExcel->getActiveSheet()->mergeCells('L'.$i.':Q'.$i);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $i,strip_tags(preg_replace("/&#?[a-z0-9]{2,8};/i"," ",$string)));
//    $objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':N7'.$i);
//    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data_name['comment']);
    $i++;
    $sno++;
endforeach;
//echo '<pre>';print_r($string);die('sasasa');
//Wrap Text
$objPHPExcel->getDefaultStyle()->applyFromArray($style_align)->getAlignment()->setWrapText(true);
//Bold Text & Font Size
$objPHPExcel->getActiveSheet()->getStyle('A5:Q6')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A5:Q6')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getStyle('A7:Q8')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getStyle('A7:Q7')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A8:Q8')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A9:Q9')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A9:Q9')->getFont()->setSize(12);
//Border
$lastcell = $i - 1;
$objPHPExcel->getActiveSheet()->getStyle('A1:Q' . $lastcell)->applyFromArray($style_border);
//Setting Width of Columns
$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
//Setting Height of Rows
$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(9)->setRowHeight(40);
for ($j = 10; $j <= $lastcell; $j++):
    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(40);
endfor;

// Rename worksheet

$objPHPExcel->getActiveSheet()->setTitle('High Five');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//Report Name
$file_name = 'highfive.xls';

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
function remove_emoji($text){
      $pattern = "~[^a-zA-Z0-9_ !@#$%^&*();\\\/|<>\"'+.,:?=-]~";
      return preg_replace($pattern,"",$text);
}
?>
