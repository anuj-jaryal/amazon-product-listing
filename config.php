<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',0);

require_once 'vendor/autoload.php';

use MarcL\AmazonAPI;
use MarcL\AmazonUrlBuilder;

function array_sort_by_column(&$arr, $col ,$order = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        if($col=='sales'){
          $type=SORT_NUMERIC;
          $sort_col[$key] = (int)str_replace(',','',$row[$col]);
        }else{
          $type=SORT_REGULAR;
          $sort_col[$key] = $row[$col];
        }
    }
    array_multisort($sort_col,$order,$type,$arr);
}


if(isset($_FILES['product']['name'])){
    //$inputFileName ="HTML.xlsx";
    $inputFileName= $_FILES['product']['tmp_name'];
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
    $data = array(1,$objPHPExcel->getActiveSheet()->toArray(null,true,true,true));

    $sheet=array();
    if($data[0]==1){
      foreach($data[1] AS $row){
        $sheet['asin'][]=$row['B'];
        $sheet['sales'][]=$row['C'];
      }
    }
    //print_r($sheet);

    $_SESSION['sheet']=$sheet;

   $keyId = 'AKIAI2C6Q24I4ZNJZUCA';
   $secretKey = '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';
   $associateId = 'romtop-20';

   $urlBuilder = new AmazonUrlBuilder($keyId,$secretKey,$associateId,'us');
   $amazonAPI = new AmazonAPI($urlBuilder, 'simple');

  $_SESSION['start']=1;
  $asinIds =array_slice($sheet['asin'],1,10);

  $items = $amazonAPI->ItemLookUp($asinIds);
  foreach ($items as $key => $value) {
    foreach($sheet['asin'] as $index=>$data){

      if($data==$value['asin']){
        $items[$key]['sales']=$sheet['sales'][$index];
      }
    }
  }
 // print_r($items);
  $_SESSION['orig_sheet']=$items;
  //print_r($_SESSION['orig_sheet']);
}

if(isset($_GET['field'])){
  $field=$_GET['field'];
  $order=$_GET['direction'];
  $dir=($order=="desc")?SORT_DESC:SORT_ASC;
  $items=$_SESSION['products'];
 // print_r($items);
//  $type=($field=='sales')?'SORT_NUMERIC':'SORT_REGULAR';
 // echo $type;
  array_sort_by_column($items,$field,$dir);
 // print_r($items);
}else{

   $_SESSION['products']=$items;
    $items=$_SESSION['products'];
}
if(empty($items)){
  header('location:index.php');
}
//var_dump($amazonAPI->GetErrors());
//echo "<pre>",print_r($items),"</pre>";


?>
