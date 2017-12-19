<?php
session_start();
header('Content-Type: text/json');
error_reporting(E_ALL);
ini_set('display_errors',0);

require_once 'vendor/autoload.php';

use MarcL\AmazonAPI;
use MarcL\AmazonUrlBuilder;

   $keyId = 'AKIAI2C6Q24I4ZNJZUCA';
   $secretKey = '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';
   $associateId = 'romtop-20';

   $urlBuilder = new AmazonUrlBuilder($keyId,$secretKey,$associateId,'us');
   $amazonAPI = new AmazonAPI($urlBuilder, 'simple');

   if(isset($_POST['page'])){
        $page=$_POST['page'];
        $start=$page+10;
        $_SESSION['start']=$start;
        $sheet=$_SESSION['sheet'];
        if($start<=count($sheet['asin'])){
            $asinIds =array_slice($sheet['asin'],$start,10);
            $items = $amazonAPI->ItemLookUp($asinIds);
              foreach ($items as $key => $value) {
                foreach($sheet['asin'] as $index=>$data){

                  if($data==$value['asin']){
                    $items[$key]['sales']=$sheet['sales'][$index];
                  }
                }
            }

               $_SESSION['products']=array_merge($_SESSION['products'],$items);
               $_SESSION['orig_sheet']=array_merge($_SESSION['orig_sheet'],$items);
         
        echo json_encode(array('start'=>$start,"data"=>$items));
        exit;
        }else{

            echo json_encode(array('start'=>false));
            exit;
        }
    }
exit;
?>