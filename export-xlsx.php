<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once 'vendor/autoload.php';

if(isset($_POST['asin'])){
    $postData=$_POST;
    //print_r($postData);
    $orig_sheet=$_SESSION['orig_sheet'];
    foreach ($orig_sheet as $key => $value) {
        foreach ($postData['asin'] as $index => $data) {
            if($value['asin']==$data){
                $post_data[$index]=$value;
                $post_data[$index]['output']=$postData['output'][$index];
            }
        }
        
    }
   // print_r($post_data);
   // die;
}else{
    header('location:index.php');
}

$objPHPExcel = new PHPExcel();


// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
// Add some data
$objPHPExcel->setActiveSheetIndex(0);

// Add column headers
$objPHPExcel->getActiveSheet()
            ->setCellValue('A1', 'NUM')
            ->setCellValue('B1', 'ASIN')
            ->setCellValue('C1', 'Estimated sales')
            ->setCellValue('D1', 'OUTPUT');


  $i=2;
 $j=0;

foreach ($post_data as $key => $value) {


            $objPHPExcel->getActiveSheet()
                        ->setCellValue('A'.$i, $j+1)
                        ->setCellValue('B'.$i, $value['asin']);


             $objPHPExcel->getActiveSheet()
                        ->setCellValue('C'.$i, $value['sales']);

             $objPHPExcel->getActiveSheet()
                    ->setCellValue('D'.$i, $value['output']);
              $i++;
              $j++;


}
// Rename worksheet
 $objPHPExcel->getActiveSheet()->setTitle('OUTPUT');
// // Set active sheet index to the first sheet, so Excel opens this as the first sheet

//Redirect output to a client’s web browser (Excel2007)
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment;filename="01Amazon.xlsx"');
 header('Cache-Control: max-age=0');
// // If you're serving to IE 9, then the following may be needed
 header('Cache-Control: max-age=1');
// // If you're serving to IE over SSL, then the following may be needed
 header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
 header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
 header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
 header ('Pragma: public'); // HTTP/1.0
 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 $objWriter->save('php://output');
 header('location:product.php');
 exit;
?>