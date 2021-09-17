<?php
error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
date_default_timezone_set('Europe/London');

/*
 * Include PHPExcel_IOFactor
 */

require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';

// 自行建立的 Excel 版型檔名
$excelTemplate = 'template-employees.xlsx';

// 判斷 Excel 檔案是否存在
if (!file_exists($excelTemplate)) {
	exit('Please run template.php first.' . EOL);
}

// 載入 Excel
$objPHPExcel = PHPExcel_IOFactory::load($excelTemplate);

// 要寫入 Excel 的 Data
$data = [
            ['ID' => '1020501', 'Name' => '王小傑', 'Sex' => 'M', 'Department' => '資訊部'],
            ['ID' => '1030501', 'Name' => '陳小明', 'Sex' => 'M', 'Department' => '財務部'],
            ['ID' => '1040501', 'Name' => '李小黃', 'Sex' => 'F', 'Department' => '業務部']
        ];

// 將 Data 寫入 Excel
for ($i = 0, $len = count($data); $i < $len; $i++) {
    // 設定 Excel 第一個頁籤 (啟始值 0 為第 1 個)，也就是 Sheet1
    $objPHPExcel->setActiveSheetIndex(0)
                    // setCellValue(欲設定 Excel 欄位, 值)，Excel 欄位字母 A 為列、數值 1 為欄，由於 $i 啟始值為 0 且須跳過 Excel 第一列的標題，因此要加 2
                    ->setCellValue('A' . ($i + 2), $data[$i]['ID'])
                    ->setCellValue('B' . ($i + 2), $data[$i]['Name'])
                    ->setCellValue('C' . ($i + 2), $data[$i]['Sex'])
                    ->setCellValue('D' . ($i + 2), $data[$i]['Department']);
}

// 依欄位內容長度，自動設定寬度
// $objPHPExcel->getActiveSheet(0)->getColumnDimension('B')->setAutoSize(true);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// 設定下載 Excel 的檔案名稱
header('Content-Disposition: attachment;filename="員工資料.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;