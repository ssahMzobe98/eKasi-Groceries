<?php
if(session_status() !== PHP_SESSION_ACTIVE){
  session_start();
}
//use controller\mmshightech\processorDao;
if(isset($_SESSION['user_agent'],$_SESSION['var_agent'])){
    $e="UKNOWN REQUEST!!";
    require_once ("../mmshightech.php");
    require_once("../mmshightech/processorNewDao.php");
    require_once ("../mmshightech/Constants/Constants.php");
    $mmshightech = new mmshightech();
    $processorNewDao = new processorNewDao($mmshightech,new Constants());

    $cur_user_row = $mmshightech->userInfo($_SESSION['user_agent']);
    if(isset($_POST['dome'])){
        $user_id=$cur_user_row['id'];
        $dome=$mmshightech->OMO($_POST['dome']);
        $response = $processorNewDao->updateBackground($dome,$user_id);
        $e=($response['response']=="S")?1:$response['data'];
    }
    elseif (isset($_FILES) && isset($_POST['filesUpload'])){
        $toProcess = [];
        $failProcess = [];
        foreach ($_FILES as $fileData){
            $ext = explode(".",$fileData['name']);
            $ext = $ext[1];
            if(in_array(strtolower($ext),['csv','xlsx','xlx'])){
                $toProcess[]=$fileData;
            }
            else {
                $failProcess[] = $fileData['name'];
            }
        }
        if(sizeof($failProcess)>0){
            $e="{".implode(",",$failProcess)."} Not supported!. Processing Failed.";
        }
        else{
            if(sizeof($toProcess)>0){
                $terminate = false;

                foreach ($toProcess as $fileData){
                    $dir = "../../csvFiles/";
                    $filename = rand(0,9999).$fileData['name'];
                    print_r($fileData);
                    if(move_uploaded_file($fileData['tmp_name'],$dir.basename($filename))){
                        $response=$processorNewDao->processCSVfileSave($filename,$cur_user_row['id']);
                        if($response['response']=="S"){
                            $processCSV = $processorNewDao->csvProcessor->processCSV($dir.$filename);


                            $header= $processCSV['header']??'';
                            $data= $processCSV['data']??[];
                            $response=$processorNewDao->uploadCSVData($header,$data,$cur_user_row['id']);
                            if($response['response']=="F"){
                                $terminate = true;
                                $e = $response['data'];
                                break;
                            }
                        }
                        else{
                            $e = $response['data'];
                            break;
                        }
                    }
                    else{
                        $e="Failed to upload {$fileData['name']}, Please resend the request";
                        break;
                    }
                }
            }
            else{
                $e = "Failed to process empty request.";
            }
        }
    }
    elseif (isset($_POST['product_id'],$_POST['user_id'],$_POST['store_uid'])){
        $product_id = $mmshightech->OMO($_POST['product_id']);
        $user_id = $mmshightech->OMO($_POST['user_id']);
        $store_uid = $mmshightech->OMO($_POST['store_uid']);
        if($user_id==$cur_user_row['id']){
            $response = $processorNewDao->processCartRequest($product_id,$user_id,$store_uid);
            $e=$response['data'];
        }
        else{
            $e = "UNKNOWN USER!!";
        }
    }
    elseif (isset($_POST['product_id_reduce'],$_POST['user_id_reduce'],$_POST['store_uid_reduce'])){
        $product_id = $mmshightech->OMO($_POST['product_id_reduce']);
        $user_id = $mmshightech->OMO($_POST['user_id_reduce']);
        $store_uid = $mmshightech->OMO($_POST['store_uid_reduce']);
        if($user_id==$cur_user_row['id']){
            $response = $processorNewDao->processCartRemovalRequest($product_id,$user_id,$store_uid);
            $e=($response['data']=="Deleted")?12:$response['data'];
        }
        else{
            $e = "UNKNOWN USER!!";
        }
    }
    elseif (isset($_POST['user_id_cart'],$_POST['store_uid_cart'])){
        $user_id = $mmshightech->OMO($_POST['user_id_cart']);
        $store_uid = $mmshightech->OMO($_POST['store_uid_cart']);
        if($user_id==$cur_user_row['id']){
            $response = $processorNewDao->getTotalOnCartCart($user_id,$store_uid);
            $e=$response['data'];
        }
        else{
            $e = "UNKNOWN USER!!";
        }
    }
    elseif(isset($_POST['ObjClass'],$_POST['NavPath'])){
        $response = $processorNewDao->todaysUserHistory(null,$_POST['ObjClass'],$_POST['NavPath'],$cur_user_row['id']);
        $e=($response['response']=="S")?1:$response['data'];
    }
    elseif(isset($_POST['prev_id_back_nav'],$_POST['obj_class_back_nav'],$_POST['url_back_nav'])){
        $response = $processorNewDao->todaysUserHistory($_POST['prev_id_back_nav'],$_POST['obj_class_back_nav'],$_POST['url_back_nav']);
        $e=($response['response']=="S")?1:$response['data'];
    }
    elseif(isset($_POST['DeliveryAddress'])){
        $DeliveryAddress = $mmshightech->OMO($_POST['DeliveryAddress']);
        $response = $processorNewDao->setNewAddress($DeliveryAddress,$cur_user_row['id']);
        $e=($response['response']=="S")?1:$response['data'];
    }
    elseif (isset($_POST['DeleveryStatusValue'])){
        $DeleveryStatusValue = $mmshightech->OMO($_POST['DeleveryStatusValue']);
        $response = $processorNewDao->setDeleveryStatusValue($DeleveryStatusValue,$cur_user_row['id']);
        $e=($response['response']=="S")?1:$response['data'];
    }
    elseif(isset($_POST['newPromoCode'])){
        $newPromoCode = $mmshightech->OMO($_POST['newPromoCode']);
        $response = $processorNewDao->useThisPromoAsUser($newPromoCode,$cur_user_row['id'],$cur_user_row['store_id']);
        $e=($response['response']=="S")?1:$response['data'];
    }
    elseif(isset($_POST['DriverTipPercentage'])){
        $DriverTipPercentage = $mmshightech->OMO($_POST['DriverTipPercentage']);
        $response = $processorNewDao->addDriverPercentageToOrderPayload($DriverTipPercentage,$cur_user_row['id']);
        $e=($response['response']=="S")?1:$response['data'];
    }
    elseif(isset($_POST['CreditStatus'])){
        $CreditStatus = $mmshightech->OMO($_POST['CreditStatus']);
        $response = $processorNewDao->setCreditStatus($CreditStatus,$cur_user_row['id']);
        $e=($response['response']=="S")?1:$response['data'];
    }
    elseif(isset($_POST['CancelOrderFromCart'])){
        $response = $processorNewDao->cancelOrderFromCart($cur_user_row['id'],$cur_user_row['store_id']);
        $e=($response['response']=="S")?1:$response['data'];
    }
//    elseif($_POST['rollOverOrderFromCheckout']){
//        $response = $processorNewDao->placePreOrderBeforePayment($_POST['rollOverOrderFromCheckout'],$cur_user_row['id'],$cur_user_row['store_id']);
//        $e=$response['response'];
//    }
    elseif(isset($_POST['cardnumber'],$_POST['cardholder'],$_POST['cvv'],$_POST['year'],$_POST['month'])){
        $cleanCardData = $mmshightech->cleanAll([$_POST['cardnumber'],$_POST['cardholder'],$_POST['cvv'],$_POST['year'],$_POST['month']]);

        $response = $processorNewDao->updateCardInfo($cleanCardData,$cur_user_row['id']);
        $e=($response['response']=="S")?1:$response['data'];
    }
    echo json_encode($e);
}
else{
  session_destroy();
  ?>
  <script>
    window.location=("../");
  </script>

  <?php
}
?>