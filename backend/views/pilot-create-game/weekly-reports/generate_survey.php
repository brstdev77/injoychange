<?php

$j = 0;
foreach ($surveyques as $question_id) {
    $question[$j] = \backend\models\PilotSurveyQuestion::find()->where(['id' => $question_id])->one();
    $j++;
}
$z = count($question);
$company = \backend\models\Company::find()->where(['id' => $comp_id])->one();
$challenge_id = $game_obj->id;
$comp_name = str_replace(' ', '-', strtolower($company->company_name));
$challenge_name = strtolower($game_obj->banner_text_1) . ' ' . strtolower($game_obj->banner_text_2);
$company_logo = '/backend/web/img/uploads/' . $company->image;
$game_start = date('F Y', $game_obj->challenge_survey_date);
$week_title = 'Survey Report - ' . $game_start;
$surveydata = $survey_model::find()->where(['challenge_id' => $challenge_id,'survey_filled' => 'Yes'])->OrderBy('user_id')->all();
$newdata=[];
foreach($surveydata as $surveyvalue)
{
  $newdata[$surveyvalue->user_id] = $surveyvalue->user_id;
}
//echo "<pre>";print_r($newdata);die;
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
$x = $z + 2;
$objPHPExcel->setActiveSheetIndex(0);
//Merge Cells for Logo Display
$objPHPExcel->getActiveSheet()->mergeCells('A1:' . chr(ord('A') + $x) . '4');
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
$objDrawing->setHeight(100);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
//$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
/* END LOGO */

/*foreach (range('A', chr(ord('A') + $x)) as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
            ->setAutoSize(true);
}*/
//Merge Cells for Challenge Name
$objPHPExcel->getActiveSheet()->mergeCells('A5:' . chr(ord('A') + $x) . '6');
//Challenge Name Display
$objPHPExcel->getActiveSheet()->setCellValue('A5', ucwords($challenge_obj->challenge_name));
//Merge Cells for Week Title
$objPHPExcel->getActiveSheet()->mergeCells('A7:' . chr(ord('A') + $x) . '8');
//Week Title Display
$objPHPExcel->getActiveSheet()->setCellValue('A7', $week_title);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setwidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
//Columns Header
$objPHPExcel->getActiveSheet()->setCellValue('A9', "#")
        ->setCellValue('B9', "Name")
        ->setCellValue('C9', "Email Id");
$chr = 'D';
foreach ($question as $Question) {
    $val = ord($chr);
    $words = str_word_count($Question->question);
        if($words > 8)
        {
           $objPHPExcel->getActiveSheet()->getColumnDimension($chr)->setWidth(40);
        }
     else {
         $objPHPExcel->getActiveSheet()->getColumnDimension($chr)->setWidth(30);
     }
    $objPHPExcel->getActiveSheet()->setCellValue($chr . '9', $Question->question);
    $val = $val + 1;
    $chr = chr($val);
}

//Add data
$i = 10;
$sno = 1;
foreach ($newdata as $userdata):
    $user = \frontend\models\PilotFrontUser::find()->where(['id' => $userdata])->one();
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sno)
            ->setCellValue('B' . $i, $user["username"])
            ->setCellValue('C' . $i, $user["emailaddress"]);
    $chr = 'D';
    foreach ($surveyques as $question_id) {

        $question = $survey_model::find()->where(['challenge_id' => $challenge_id, 'user_id' => $userdata, 'survey_question_id' => $question_id])->one();
        $val = ord($chr);
        $objPHPExcel->getActiveSheet()->setCellValue($chr . $i, json_decode($question->survey_response));
        $val = $val + 1;
        $chr = chr($val);
    }
    $i++;
    $sno++;
endforeach;

//Wrap Text
$objPHPExcel->getDefaultStyle()->applyFromArray($style_align)->getAlignment()->setWrapText(true);
//Bold Text & Font Size
$objPHPExcel->getActiveSheet()->getStyle('A5:N6')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A5:N6')->getFont()->setSize(22);
$objPHPExcel->getActiveSheet()->getStyle('A7:N8')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A7:N8')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A9:N9')->applyFromArray($style_bold);
$objPHPExcel->getActiveSheet()->getStyle('A9:N9')->getFont()->setSize(12);
//Border
$lastcell = $i - 1;
$objPHPExcel->getActiveSheet()->getStyle('A1:N' . $lastcell)->applyFromArray($style_border);
//Setting Width of Columns
//$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(13);
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
//$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
//Setting Height of Rows
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(9)->setRowHeight(40);
for ($j = 10; $j <= $lastcell; $j++):
  $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(50);
endfor;
// Rename worksheet

$objPHPExcel->getActiveSheet()->setTitle('Weekly Report');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//Report Name
$file_name = ucfirst($comp_name) . '_survey.xls';

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
