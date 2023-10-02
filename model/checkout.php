<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user_agent'],$_SESSION['var_agent'])){
    require_once("../controller/mmshightech.php");
    require_once("../controller/mmshightech/StorePdo.php");
    $mmshightech=new mmshightech();
    $StorePdo = new StorePdo($mmshightech);
    $cur_user_row = $mmshightech->userInfo($_SESSION['user_agent']);
    if($cur_user_row['user_type']=='app'){
        date_default_timezone_set('Africa/Johannesburg');
        if(isset($_GET['price'])){
            $price = $_GET['price'];
            $backNavigation = $StorePdo->backStoreNavigation($cur_user_row['id']);
            $getCartItem = $StorePdo->getCartPayload($cur_user_row['id'],$cur_user_row['store_id']);
            $getCartItem['promo_price'] = empty($getCartItem['promo_code'])?0.00:$StorePdo->getPromoPrice($getCartItem['promo_code'],$cur_user_row['store_id']);
            $getCartItem['driver_tip_amount']=(($getCartItem['driver_tip']/100)*$getCartItem['sub_total_price']);
            $getCartItem['fee'] = 3.50;
            $getCartItem['delivery_fee'] = 35.00;
            $getCartItem['total'] = ($getCartItem['driver_tip_amount']+$getCartItem['delivery_fee']+$getCartItem['fee']+$getCartItem['sub_total_price'])-$getCartItem['promo_price'];
            ?>
            <div class="tag-body-con" style="display:flex;">
                <span style="color:#000000;font-size: medium;font-weight: bolder;padding: 0 10px;">Pay Processing</span>
                <span style="color:#000000;font-size: medium;font-weight: bolder;padding: 0 10px;"><i onclick="navigateBack('<?php echo $backNavigation['prev_id'];?>','<?php echo $backNavigation['obj_class'];?>','<?php echo $backNavigation['url'];?>')" class="fa fa-arrow-left" aria-hidden="true"></i></span>
                <input id="switch-two"
                    <?php if($getCartItem['delivery_type']=='Delivery'){echo 'checked';};?>
                       type="checkbox"
                       onchange="deliveryStatusCall('<?php echo $getCartItem['delivery_type'];?>')"
                >
                <script>
                    $(function(){
                        document.getElementById('switch-two').switchButton({
                            onlabel: 'Delivery',
                            offlabel: 'Collection'
                        });
                    });
                </script>
                <span class="errorToggleShow" hidden=""></span>
            </div>
            <?php
            if(empty($getCartItem['delivery_address'])){
                include_once('./addressForm.php');
            }
            else{
                ?>
                <style>
                    .newPhase{
                        width:100%;
                    }
                    .AddressConfirmation{
                        width: 100%;
                        padding: 10px 10px;
                        /*border:1px solid #0A2558;*/
                        display: flex;
                    }
                    .text-address{
                        width:80%;
                        color:#000000;
                        font-size: smaller;
                        font-weight: bolder;
                        text-align: left;
                        padding: 10px 10px;
                        overflow-x: hidden;
                    }
                    .text-edit{
                        width:20%;
                        text-align: center;
                        background: #cce5ff;
                        height: 100%;
                        border-radius: 40px;
                        box-shadow: 0 2px 3px 0 rgba(0,0,0,.5);
                        padding: 10px 10px;
                    }
                    .text-edit:hover{
                        box-shadow: 0 2px 3px 0 rgba(0,0,0,.1);
                        background: #dddddd;
                    }
                    .promoCodeSpace{
                        padding: 10px 10px;
                    }
                    .promoCodeSpace input{
                        width: 70%;
                        padding: 10px 10px;
                        border-radius: 50px;
                        border:none;
                        border-bottom: 3px solid #cce5ff;
                    }
                    .promoCodeSpace span{
                        padding: 10px 10px;
                        text-align: center;
                        box-shadow: 0 2px 3px 0 rgba(0,0,0,.4);
                        background: #cce5ff;
                        border-radius: 50px;

                    }
                    .promoCodeSpace span:hover{
                        box-shadow: 0 2px 3px 0 rgba(0,0,0,.1);
                        background: #dddddd;
                    }
                    .orderDetailsPayment{
                        box-shadow: 0 2px 3px 0 rgba(0,0,0,.5);
                        background: white;
                        border-radius: 10px;
                        padding: 10px 10px;
                    }
                    .foot-tend:hover{
                        box-shadow: 0 2px 3px 0 rgba(0,0,0,.1);
                        background: #1b74e4;
                    }
                </style>
                <div class="checkoutModel">
                    <div class="newPhase">
                        <div class="AddressConfirmation">
                            <div class="text-address"><?php echo $getCartItem['delivery_address'];?></div>
                            <div class="text-edit" onclick="NavLoader('.newPhase','../model/addressForm.php')">edit</div>
                        </div>
                        <hr/>
                        <div class="promoCodeSpace">
                            <label>If you have a promo code, please enter it here.</label>
                            <input type="text" value="<?php echo $getCartItem['promo_code'];?>" class="PromoCode" placeholder="Enter Promo Code" > <span class="addPromoCode" onclick="addPromoCode()">Add Code</span>
                            <div class="errorPackPromo" hidden=""></div>
                        </div>
                        <hr/>
                        <h4>Tip your driver</h4>
                        <center>
                            <div class="" style="display: flex;text-align: center;align-content: center;align-items: center;">
                                <div style="padding: 20px 20px;">
                                    <label for="4percent">4%</label>
                                    <input  onclick="checkedTip(4)" name="percent" <?php if($getCartItem['driver_tip']==4){echo'checked';};?> style="padding: 10px 10px;width: 40px;height: 40px;" type="radio" id="4percent" >
                                </div>
                                <div style="padding: 20px 20px;">
                                    <label for="6percent">6%</label>
                                    <input onclick="checkedTip(6)" name="percent" <?php if($getCartItem['driver_tip']==6){echo'checked';};?> style="padding: 10px 10px;width: 40px;height: 40px;" type="radio" id="6percent" >
                                </div>
                                <div style="padding: 20px 20px;">
                                    <label for="8percent">8%</label>
                                    <input onclick="checkedTip(8)" name="percent" <?php if($getCartItem['driver_tip']==8){echo'checked';};?> style="padding: 10px 10px;width: 40px;height: 40px;" type="radio" id="8percent" >
                                </div>
                                <div style="padding: 20px 20px;">
                                    <label for="10percent">10%</label>
                                    <input onclick="checkedTip(10)" name="percent" <?php if($getCartItem['driver_tip']==10){echo'checked';};?> style="padding: 10px 10px;width: 40px;height: 40px;" type="radio" id="10percent" >
                                </div>
                            </div>
                            <div class="errorDisplayDriverTip" hidden=""></div>
                        </center>
                    </div>
                    <div style="padding: 10px 10px;">
                        <h2>Credit Balance</h2>
                        <div  class="orderDetailsPayment" style="display: flex;">
                            <div style="padding: 1px 1px;width:80%;">
                                <p>Amount on Credit</p>
                                <p>R<?php
                                    $getCartItem['credit_balance'] = empty($getCartItem['credit_balance'])?0:$getCartItem['credit_balance'];
                                    echo number_format($getCartItem['credit_balance'],2);?></p>
                            </div>
                            <div style="padding: 1px 1px;">
                                <input id="switch-twoa"
                                    <?php $var = 'Y';if($getCartItem['use_credit']=='Y'){echo 'checked';$var = 'N';};?>
                                       type="checkbox"
                                       onchange="setUserCreditActive('<?php echo $var;?>')"
                                >
                                <script>
                                    $(function(){
                                        document.getElementById('switch-twoa').switchButton({
                                            onlabel: 'ON',
                                            offlabel: 'OFF'
                                        });
                                    });
                                </script>
                                <span class="errorToggleShowaa" hidden=""></span>
                            </div>
                        </div>
                        <br>
                        <h2>Order Amount</h2>
                        <div  class="orderDetailsPayment" style="display: flex;">
                            <div style="width:70%;">
                                <p>Subtotal</p>
                                <p>Delivery Fee</p>
                                <p>Sys Fee</p>
                                <p>Driver Tip</p>
                                <p>Discount</p>
                                <p>Credit in Used</p>
                                <p>Total</p>
                            </div>
                            <div>
                                <p>R<?php echo number_format($getCartItem['sub_total_price'],2);?></p>
                                <p>R<?php echo number_format($getCartItem['delivery_fee'],2);?></p>
                                <p>R<?php echo number_format($getCartItem['fee'],2);?></p>
                                <p>R<?php echo number_format($getCartItem['driver_tip_amount'],2);?></p>
                                <p>R<?php echo number_format(($getCartItem['promo_price']>0)?-$getCartItem['promo_price']:0.00,2);?></p>
                                <p>R<?php
                                    if($getCartItem['use_credit']=='Y'){
                                        echo "-".number_format($getCartItem['credit_balance'],2);
                                    }else{
                                        echo number_format(0,2);
                                    }?>
                                </p>
                                <p>R<?php if($getCartItem['use_credit']=='Y'){$getCartItem['total']-=$getCartItem['credit_balance'];}
                                    echo number_format($getCartItem['total'],2);?></p>
                            </div>

                        </div>
                        <br>
                        <input type="hidden" value="'<?php echo json_encode($getCartItem);?>'" disabled class="rollOverOrder">
                        <div onclick="NavLoader(
                            '.checkoutModel',
                            '../model/payment_details.php')"  class="orderDetailsPayment foot-tend"
                             style="background:#0A2558;
                                 text-align:center;
                                 color: white;
                                 font-size: large;
                                 font-weight: bolder;
                                 border:2px solid white;
                          ">
                            PROCEED TO PAYMENT
                        </div>
                    </div>

                    <div class="cancelOrderFromCart" style="background: none;padding: 10px 10px;color:red;text-align: center;font-weight: bolder;font-size: x-small" onclick="cancelOrderFromCart('<?php echo $cur_user_row['id']?>','<?php echo $cur_user_row['store_id'];?>')">CANCEL ORDER</div>

                </div>

                <?php

            }
        }
        else{
            echo"UNKNOWN REQUEST!!";
        }
    }
    else{
        session_destroy();
        ?>
        <script>
            window.location=("../");
        </script>
        <?php
    }
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
