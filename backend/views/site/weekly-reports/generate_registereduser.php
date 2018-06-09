<?php

//$challenge_name = str_replace(' ', '-', strtolower($challenge_obj->challenge_name));

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
$objPHPExcel->getActiveSheet()->mergeCells('A1:K4');
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
$objPHPExcel->getActiveSheet()->mergeCells('A5:K6');
//Challenge Name Display
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Registered User');
//Merge Cells for Challenge Name

foreach ($data as $data_name):
    $objPHPExcel->getActiveSheet()->setCellValue('A7', 'S.No.');
    $objPHPExcel->getActiveSheet()->setCellValue('B7', $data_name[0]);
    $objPHPExcel->getActiveSheet()->mergeCells('C7:D7');
    $objPHPExcel->getActiveSheet()->setCellValue('C7', $data_name[1]);
    $objPHPExcel->getActiveSheet()->mergeCells('E7:F7');
    $objPHPExcel->getActiveSheet()->setCellValue('E7', $data_name[2]);
    $objPHPExcel->getActiveSheet()->setCellValue('G7', $data_name[3]);
    $objPHPExcel->getActiveSheet()->setCellValue('H7', $data_name[4]);
    $objPHPExcel->getActiveSheet()->setCellValue('I7', $data_name[5]);
    $objPHPExcel->getActiveSheet()->mergeCells('J7:K7');
    $objPHPExcel->getActiveSheet()->setCellValue('J7', $data_name[6]);
    /*$objPHPExcel->getActiveSheet()->setCellValue('A7', $data_name[0])
           ->setCellValue('B7', $data_name[1]);*/
//    $objPHPExcel->getActiveSheet()->mergeCells('C7:N7');
//    $objPHPExcel->getActiveSheet()->setCellValue('C7', $data_name[2]);
endforeach;
// Add data
 $sno =1;
$i = 8;
foreach ($dataxls as $data):
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sno);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data['username']);
    $objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':D'.$i);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $data['email']);
    $objPHPExcel->getActiveSheet()->mergeCells('E'.$i.':F'.$i);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $data['company_name']);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $data['team_name']);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $data['last_login']);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $data['device']);
     $objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':K'.$i);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $data['browser']);
//    $objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':N7'.$i);
//    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data_name['comment']);
    $i++;
    $sno++;
endforeach;

//Wrap Text
$objPHPExcel->getDefaultStyle()->applyFromArray($style_align)->getAlignment()->setWrapText(true);
//Bold Text & Font Size
$objPHPExcel->getActiveSheet()->getStyle('A5:K6')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A5:K6')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getStyle('A7:K7')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A7:k7')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A8:K8')->getFont()->setSize(12);
//Border
$lastcell = $i - 1;
$objPHPExcel->getActiveSheet()->getStyle('A1:K' . $lastcell)->applyFromArray($style_border);
//Setting Width of Columns
$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
//Setting Height of Rows
$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(40);
//$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(20);
//$objPHPExcel->getActiveSheet()->getRowDimension(9)->setRowHeight(40);
for ($j = 8; $j <= $lastcell; $j++):
    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(30);
endfor;

// Rename worksheet

$objPHPExcel->getActiveSheet()->setTitle('Registerd User');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//Report Name
$file_name = 'RegisteredUser.xls';

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
