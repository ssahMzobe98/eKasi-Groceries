<?php
class ProcessorNewDao{
    private mmshightech $mmshightech;
    public csvProcessor $csvProcessor;
    private Constants $Constants;
    public function __construct(mmshightech $mmshightech,Constants $Constants)
    {

        include_once ("csvProcessor.php");
        $this->mmshightech = $mmshightech;
        $this->csvProcessor = new csvProcessor();
        $this->Constants = $Constants;
    }
    public function processCSVfileSave(string $filename = '',int $adminId=0):array{
        $sql = "insert into csv_uploads_for_product_creation(csv,time_uploaded,uploaded_by)values(?,NOW(),?)";
        $response = $this->mmshightech->postDataSafely($sql,'ss',[$filename,$adminId]);
        if(is_numeric($response)){
            return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
        }
        else{
            return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];
        }
    }
    public function uploadCSVData(string $header = "",array $data=[],int $adminId=0):array{
        $sql = "insert into products ($header	
                                    )values(
                                            ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),?
                                    )";
        $strParams = "sssssssssssssssssssssssssssssssss";
        $isProcessed = true;
        $error=[];
        foreach ($data as $d){
            $params = $d;
            $params[]=$adminId;
            $response = $this->mmshightech->postDataSafely($sql,$strParams,$params);
            if(!is_numeric($response)){
                $isProcessed=false;
                $error[]=$response;
                break;
            }
        }
        if($isProcessed){
            return ['response'=>"S",'data'=>"Success"];
        }
        return ['response'=>"F",'data'=>$error];
    }
    public function updateBackground(int $dome=0,int $user_id=null):array{
        $sql = "update users set background = ? where id = ?";
        $response = $this->mmshightech->postDataSafely($sql,'ss',[$dome,$user_id]);
        if(is_numeric($response)){
            return ['response'=>"S",'data'=>"Success"];
        }
        else{
            return ['response'=>"F",'data'=>$response];
        }
    }
    private function productAlreadyInCart(int $product_id = 0,int $user_id=0,int $store_uid = 0):int{
        $sql = "select quantity from cart where product_id = ? and user_id = ? and store_id = ?";
        $response = $this->mmshightech->getAllDataSafely($sql,'sss',[$product_id,$user_id,$store_uid])[0]??[];
        return $response['quantity']??0;
    }
    public function getTotalOnCartCart(int $user_id=0,int $store_uid = 0):array{
        $sql = "select sum(quantity) as quantity from cart where user_id = ? and store_id = ?";
        $response = $this->mmshightech->getAllDataSafely($sql,'ss',[$user_id,$store_uid])[0]??[];
        return ['response'=>"S",'data'=>$response['quantity']??0];
    }
    private function addProductIntoCart(int $product_id = 0,int $user_id = 0,int $store_uid = 0,int $quantity =1){
        $sql = "insert into cart(product_id,user_id,store_id,quantity,time_added)values(?,?,?,?,NOW())";
        $response = $this->mmshightech->postDataSafely($sql,'ssss',[$product_id,$user_id,$store_uid,$quantity]);
        if(is_numeric($response)){
            return ['response'=>"S",'data'=>1];
        }
        else{
            return ['response'=>"F",'data'=>$response];
        }
    }
    public function processCartRequest(int $product_id = 0,int $user_id=0,int $store_uid = 0):array{
        $quantity =$this->productAlreadyInCart($product_id,$user_id,$store_uid);
        if($quantity>0){
            $quantity+=1;
            return $this->updateProductInCart($product_id,$user_id,$store_uid,$quantity);
        }
        return $this->addProductIntoCart($product_id,$user_id,$store_uid);
    }
    private function updateProductInCart(int $product_id=0, int $user_id = 0, int $store_uid = 0, int $quantity = 1):array
    {
        $sql = "update cart set quantity=?,time_added=NOW() where product_id =? and user_id=? and store_id=?";
        $response = $this->mmshightech->postDataSafely($sql,'ssss',[$quantity,$product_id,$user_id,$store_uid]);
        if(is_numeric($response)){
            return ['response'=>"S",'data'=>$quantity];
        }
        else{
            return ['response'=>"F",'data'=>$response];
        }
    }
    private function removeProductFromCart(int $product_id=0, int $user_id=0, int $store_uid=0):array
    {
        $sql = "delete from cart where product_id ={$product_id} and user_id={$user_id} and store_id={$store_uid}";
        if($this->mmshightech->connection->query($sql)){
            return ['response'=>"S",'data'=>"Deleted"];
        }
        else{
            return ['response'=>"F",'data'=>$this->mmshightech->connection->error];
        }
    }
    public function processCartRemovalRequest(int $product_id = 0, int $user_id = 0, int $store_uid = 0):array
    {
        $quantity =$this->productAlreadyInCart($product_id,$user_id,$store_uid)-1;
        if($quantity>0){
            return $this->updateProductInCart($product_id,$user_id,$store_uid,$quantity);
        }
        return $this->removeProductFromCart($product_id,$user_id,$store_uid);
    }
    private function getCurrentHistoryIdToConvertToLast(int $id=null):int{
        $sql="select id from user_history where user_id =? order by id desc limit 1";
        $response = $this->
                mmshightech->
                getAllDataSafely(
                    $sql,
                    's',
                    [$id]
                )[0];
        return intval($response['id']??1);
    }
    private function updateHistoryPrevColumn($response,$id):array{
        $sql = "update user_history set prev_id=? where user_id=? and id =?";
        $response=$this->mmshightech->postDataSafely(
            $sql,
            'sss',
            [$response,$id,$response]
        );
        if(is_numeric($response)){
            return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
        }
        return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];
    }
    public function todaysUserHistory(int $prevIdFromBackNav=null,string $ObjClass="", string $NavPath="", int $id=null):array
    {
        $prevId=$prevIdFromBackNav??$this->getCurrentHistoryIdToConvertToLast($id);
        $sql="insert into user_history(prev_id,url,obj_class,user_id,date_time_nav)values(?,?,?,?,NOW())";
        $response = $this->mmshightech->postDataSafely(
            $sql,
            'ssss',
            [$prevId,$NavPath,$ObjClass,$id]
        );
        if($prevId==1){
            $response = $this->updateHistoryPrevColumn($response,$id);
        }
        if(is_numeric($response)){
            return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
        }
        return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];
    }
    public function todaysUserHistoryBackNav(
        int $prev_id_back_nav = null,
        string $obj_class_back_nav=null,
        string $url_back_nav = null,
        int $id=null):array
    {
        $prevId=$prev_id_back_nav;
        $sql="insert into user_history(prev_id,url,obj_class,user_id,date_time_nav)values(?,?,?,?,NOW())";
        $response = $this->mmshightech->postDataSafely(
            $sql,
            'ssss',
            [$prevId,$url_back_nav,$obj_class_back_nav,$id]
        );
        //echo '{'.$response.' === }';
        if(is_numeric($response)){
            return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
        }
        return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];

    }
    public function getCartDetails(int $id=null, int $store_id=null):array{
        $sql = "select 
                    c.store_id as store_id,
                    c.product_id as product_id,
                    c.quantity as quantity,
                    p.price_usd as price,
                    p.product_description as product_description,
                    p.product_thumbnail as product_thumbnail,
                    p.is_instock as is_instock,
                    p.instock as instock
                from cart as c
                    left join products as p on p.id = c.product_id
                where c.store_id = ? and c.user_id = ?
                ";
        return $this->mmshightech->getAllDataSafely($sql,'ss',[$store_id,$id]);
    }
    public function setNewAddress(string $DeliveryAddress=null,int $user_id=null):array{
        if($this->isActiveAddress($user_id)){
            $response = $this->deActivateActiveAddress($user_id);
            if(!is_numeric($response)){
                return ['response'=>"F",'data'=>$response];
            }
        }
        $sql ="insert into delivery_addresses(user_id,address,extra,status,date_added)values(?,?,?,?,NOW())";
        $response = $this->mmshightech->postDataSafely(
            $sql,
            'ssss',
            [$user_id,$DeliveryAddress,'','A']
        );
        if(is_numeric($response)){
            return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
        }
        return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];
    }
    private function isThereAnyActivePromoOnThisUser(int $user_id=null,int $store_id=null):bool
    {
        $sql = "select * from app_user_promo_code where user_id=? and status='A'";
        $row_data = $this->mmshightech->getAllDataSafely($sql,'s',[$user_id])??[];
        if(empty($row_data)){
            return false;
        }
        $activePromo = [];
        foreach ($row_data as $data){
            if(!$this->isValidPromoCode($data['promo_code'],$store_id)){
                $response = $this->diActivatePromoCodeFromThisUser($data['promo_code'],$data['user_id']);
                if($response['response']=="F"){
                    error_log(json_encode($response));
                }
            }
            else{
                $activePromo[] = $data;
            }
        }
        return !empty($activePromo);
    }
    private function diActivatePromoCodeFromThisUser(string $promo_code = null,int $user_id=null):array{
        $sql = "update app_user_promo_code set status = 'D' where promo_code = ? and user_id = ?";
        $response = $this->mmshightech->postDataSafely(
            $sql,
            'ss',
            [$promo_code,$user_id]
        );
        if(is_numeric($response)){
            return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
        }
        return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];
    }
    public function useThisPromoAsUser(string $newPromoCode=null,int $user_id=null,int $store_id=null):array
    {
        if($this->isValidPromoCode($newPromoCode,$store_id)){
            if(!$this->isPromoIsUsed($newPromoCode,$user_id)){
                if(!$this->isThereAnyActivePromoOnThisUser($user_id,$store_id)){
                    $sql ="insert into app_user_promo_code(promo_code,user_id,time_added)values(?,?,NOW())";
                    $response = $this->mmshightech->postDataSafely(
                        $sql,
                        'ss',
                        [$newPromoCode,$user_id]
                    );
                    if(is_numeric($response)){
                        return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
                    }
                    return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];
                }
                return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>"You have an active promo!!"];
            }
            return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>"You've used this promo"];
        }
        return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>"Promo NOT valid!."];
    }
    private function isPromoIsUsed(string $newPromoCode = null,int $user_id=null):bool
    {
        $sql = "select * from app_user_promo_code where promo_code=? and user_id =? and status='A' order by id DESC limit 1";
        return $this->mmshightech->numRows($sql,'ss',[$newPromoCode,$user_id])==1;
    }
    private function isValidPromoCode(string $newPromoCode=null,int $store_id=null):bool
    {
        $sql = "select 
                    *
                    from store_promo_code 
                where promo_code=? 
                  and store_id=? 
                  and (
                      NOW()>start_date 
                          and 
                      NOW()<end_date
                      )
                order by id DESC limit 1";
        return $this->mmshightech->numRows($sql,'ss',[$newPromoCode,$store_id])==1;
    }
    public function setDeleveryStatusValue(string $DeleveryStatusValue=null,int $user_id= null):array{
        $sql="update users set delivery_type = ? where id = ?";
        $response = $this->mmshightech->postDataSafely(
            $sql,
            'ss',
            [$DeleveryStatusValue,$user_id]
        );
        if(is_numeric($response)){
            return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
        }
        return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];
    }
    private function isActiveAddress(int $user_id = null):bool
    {
        $sql = "select * from delivery_addresses where user_id=? and status='A'";
        return $this->mmshightech->numRows($sql,'s',[$user_id])>0;
    }
    private function deActivateActiveAddress(int $user_id = null)
    {
        $sql = "update delivery_addresses set status = 'D' where user_id = ?";
        $response =$this->mmshightech->postDataSafely(
            $sql,
            's',
            [$user_id]
        );
        if(is_numeric($response)){
            return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
        }
        return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];
    }
    public function addDriverPercentageToOrderPayload(int $DriverTipPercentage=null, int $id = null)
    {
        $sql="update users set driver_tip=? where id=?";
        $response = $this->mmshightech->postDataSafely(
            $sql,
            'ss',
            [$DriverTipPercentage,$id]
        );
        if(is_numeric($response)){
            return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
        }
        return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];
    }

    public function setCreditStatus(string $CreditStatus=null, int $id=null):array
    {
        $sql="update credit_balance set use_credit = ? where user_id = ?";
        $response = $this->mmshightech->postDataSafely(
            $sql,
            'ss',
            [$CreditStatus,$id]
        );
        if(is_numeric($response)){
            return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
        }
        return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];
    }

    public function cancelOrderFromCart(int $id=null, int $store_id=null):array
    {
        $sql = "delete from cart where user_id ={$id} and store_id={$store_id}";
        if($this->mmshightech->connection->query($sql)){
            return ['response'=>"S",'data'=>"Deleted"];
        }
        else{
            return ['response'=>"F",'data'=>$this->mmshightech->connection->error];
        }
    }
    public function placePreOrderBeforePayment($rollOverOrderFromCheckout, int $id=null, int $store_id=null):array
    {
        $order = json_decode($rollOverOrderFromCheckout);
        echo"<pre>";
        print_r($order);
        echo"</pre>";
        return ['response'=>'data_not_reported'];
    }

    public function updateCardInfo( array $cleanCardData = [], int $id=null):array
    {
        $sql = "update users set card_number=?,card_name=?,card_cvv=?,card_expiry_date=? where id=?";
        $response = $this->mmshightech->postDataSafely(
            $sql,
            'sssss',
            [$cleanCardData[0],$cleanCardData[1],$cleanCardData[2],$cleanCardData[3].' '.$cleanCardData[4],$id]
        );
        if(is_numeric($response)){
            return ['response'=>$this->Constants->SUCCESS_STATUS,'data'=>"Success"];
        }
        return ['response'=>$this->Constants->FAILED_SUCCESS,'data'=>$response];
    }
}
?>
