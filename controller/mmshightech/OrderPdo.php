<?php
class OrderPdo
{
    private mmshightech $mmshightech;

    public function __construct(mmshightech $mmshightech)
    {
        $this->mmshightech = $mmshightech;
    }

    public function CreateNewOrder(array $getCartItem=[]): array
    {
        if(empty($getCartItem)){
            return ['response'=>'F','data'=>'Failed to place Invalid order'];
        }
        $sql="insert into orders(
                   user_id,
                   store_id,
                   user_name,
                   delivery_address,
                   user_email,
                   user_phone,
                   delivery_type,
                   payment_type,
                   is_promo_code_used,
                   sub_total_price,
                   credit_balance,
                   is_credit_use,
                   process_status,
                   promo_price,
                   promo_code,
                   driver_tip_amount,
                   sys_fee,
                   delivery_fee,
                   order_total,
                   created_datetime)
            values(?,?,?,?,?,?,?,?,?,?,?,?,'0',?,?,?,?,?,?,NOW())";
        $strParams = 'ssssssssssssssssss';
        $is_promo_code=empty($getCartItem['promo_code'])?'N':'Y';
        $params = [
            $getCartItem['user_id'],
            $getCartItem['store_id'],
            $getCartItem['user_name'],
            $getCartItem['delivery_address'],
            $getCartItem['email'],
            $getCartItem['phone'],
            $getCartItem['delivery_type'],
            $getCartItem['payment_type'],
            $is_promo_code,
            $getCartItem['sub_total_price'],
            $getCartItem['credit_balance'],
            $getCartItem['use_credit'],
            $getCartItem['promo_price'],
            $getCartItem['promo_code'],
            $getCartItem['driver_tip_amount'],
            $getCartItem['fee'],
            $getCartItem['delivery_fee'],
            $getCartItem['total']
        ];
        $result = $this->mmshightech->postDataSafely($sql,$strParams,$params);
        if(!is_numeric($result)){
            return ['response'=>'F','data'=>$result];
        }
        else{
            $order_id = $result;
            $order_details =(array)json_decode($getCartItem['order_details']);
            if(empty($order_details)){
                $response = $this->revertOrderNo($order_id,json_encode($order_details));
                if($response['response']=='S'){
                    return ['response'=>'S','data'=>'Failed to place order. Please try again.'];
                }
                else{
                    return ['response'=>'F','data'=>$response,'response_error'=>'failed to revert order {'.$order_id.'}'];
                }
            }
            else{
                $response = $this->createOrderDetails($order_details,$order_id);
                if($response['response']=='F'){
                    $response = $this->revertOrderNo($order_id,json_encode($order_details));
                    if($response['response']=='S'){
                        return ['response'=>'S','data'=>'Failed to create order details. Please try again.'];
                    }
                    else{
                        return ['response'=>'F','data'=>$response,'response_error'=>'failed to revert order {'.$order_id.'}'];
                    }
                }
                else{
                    return $this->clearCart($getCartItem['user_id']);
                }
            }
        }
    }
    private function clearCart(int $user_id=null): array
    {
        $sql = "delete from cart where user_id ={$user_id}";
        if($this->mmshightech->connection->query($sql)){
            return ['response'=>"S",'data'=>"Deleted"];
        }
        else{
            return ['response'=>"F",'data'=>$this->mmshightech->connection->error];
        }
    }
    private function revertOrderNo(int $order_id = null,string $order_details=null):array
    {
        $sql = "update orders set 
                  is_reverted='Y', 
                  process_status= '15', 
                  revert_reason = 'Fraud attempt: order has no order details.{$order_details}' 
              where uid=?";
        $response = $this->mmshightech->postDataSafely($sql,'s',[$order_id]);
        if(!is_numeric($response)){
            return ['response'=>'F','data'=>$response];
        }
        else{
            return ['response'=>'S','data'=>$response];
        }
    }
    private function createOrderDetails(array $order_detailsArr = [],int $order_id=null):array
    {
        $sql = "insert into order_details(
                          order_id,
                          store_id,
                          product_id,
                          menu_id,
                          product_handle,
                          product_description,
                          product_weight,
                          product_length,
                          product_width,
                          product_height,
                          product_hs_code,
                          product_discountable,
                          product_profile_name,
                          product_profile_type,
                          variant_barcode,
                          price,
                          is_instock,
                          quantity,
                          amended_quantity,
                          is_procesed,
                          is_packed,
                          time_packed,
                          is_removed,
                          time_removed,
                          time_added)
                    values(
                           ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,0,'N','N','null','N','null',NOW()
                    )";
        $strParams = "ssssssssssssssssss";

        foreach ($order_detailsArr as $order_details){
            echo"<pre>";
            print_r($order_details);
            echo"</pre>";
            $params = [
                $order_id,
                intval($order_details['store_id']),
                $order_details['product_id'],
                $order_details['menu_id'],
                $order_details['product_handle'],
                $order_details['product_description'],
                $order_details['product_weight'],
                $order_details['product_length'],
                $order_details['product_width'],
                $order_details['product_height'],
                $order_details['product_hs_code'],
                $order_details['product_discountable'],
                $order_details['product_profile_name'],
                $order_details['product_profile_type'],
                $order_details['variant_barcode'],
                $order_details['price'],
                $order_details['is_instock'],
                $order_details['quantity']
            ];
            $response = $this->mmshightech->postDataSafely($sql,$strParams,$params);
            if(!is_numeric($response)){
                return ['response'=>'F','data'=>$response];
            }
        }
    }
}