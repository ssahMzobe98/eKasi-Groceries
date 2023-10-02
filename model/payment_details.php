<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user_agent'],$_SESSION['var_agent'])){
    require_once("../controller/mmshightech.php");
    require_once("../controller/mmshightech/StorePdo.php");
    require_once("../controller/mmshightech/OrderPdo.php");
    $mmshightech=new mmshightech();
    $StorePdo = new StorePdo($mmshightech);
    $OrderPdo = new OrderPdo($mmshightech);
    $cur_user_row = $mmshightech->userInfo($_SESSION['user_agent']);
    if($cur_user_row['user_type']=='app') {

        $backNavigation = $StorePdo->backStoreNavigation($cur_user_row['id']);
        $getCartItem = $StorePdo->getCartPayload($cur_user_row['id'],$cur_user_row['store_id']);
        $getCartItem['store_id']=$cur_user_row['store_id'];
        $getCartItem['promo_price'] = empty($getCartItem['promo_code'])?0.00:$StorePdo->getPromoPrice($getCartItem['promo_code'],$cur_user_row['store_id']);
        $getCartItem['driver_tip_amount']=(($getCartItem['driver_tip']/100)*$getCartItem['sub_total_price']);
        $getCartItem['payment_type'] = 'CARD';
        $getCartItem['fee'] = 3.50;
        $getCartItem['delivery_fee'] = 35.00;
        $getCartItem['total'] = ($getCartItem['driver_tip_amount']+$getCartItem['delivery_fee']+$getCartItem['fee']+$getCartItem['sub_total_price'])-$getCartItem['promo_price'];
        if((empty($getCartItem['card_number'])|| $getCartItem['card_number']==0) || empty($getCartItem['card_cvv']) || empty($getCartItem['card_expiry_date'])){
            ?>
            <style>
                .credit-card {
                    width: 100%;
                    height: auto;
                    margin: 60px auto 0;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    background-color: #fff;
                    box-shadow: 1px 2px 3px 0 rgba(0,0,0,.10);
                    color:#000000;
                }
                .form-header {
                    height: 60px;
                    padding: 20px 30px 0;
                    border-bottom: 1px solid #e1e8ee;
                }
                .form-body {
                    height: 340px;
                    padding: 30px 30px 20px;
                }
                .title {
                    font-size: 18px;
                    margin: 0;
                    color: #5e6977;
                }
                .card-number,.card-holder,
                .cvv-input input,
                .month select,
                .year select {
                    font-size: 14px;
                    font-weight: 100;
                    line-height: 14px;
                }

                .card-number,.card-holder,
                .month select,
                .year select {
                    font-size: 14px;
                    font-weight: 100;
                    line-height: 14px;
                }

                .card-number,.card-holder,
                .cvv-details,
                .cvv-input input,
                .month select,
                .year select {
                    opacity: .7;
                    color: #86939e;
                }
                .card-number,.card-holder {
                    width: 100%;
                    margin-bottom: 20px;
                    padding-left: 20px;
                    border: 2px solid #e1e8ee;
                    border-radius: 6px;
                }
                .month select,
                .year select {
                    width: 145px;
                    margin-bottom: 20px;
                    padding-left: 20px;
                    border: 2px solid #e1e8ee;
                    border-radius: 6px;
                    background: url('../img/caret.png') no-repeat;
                    background-position: 85% 50%;
                    -moz-appearance: none;
                    -webkit-appearance: none;
                }
                .month select {
                    float: left;
                }
                .year select {
                    float: right;
                }
                .cvv-input input {
                    float: left;
                    width: 145px;
                    padding-left: 20px;
                    border: 2px solid #e1e8ee;
                    border-radius: 6px;
                    background: #fff;
                }

                .cvv-details {
                    font-size: 12px;
                    font-weight: 300;
                    line-height: 16px;
                    float: right;
                    margin-bottom: 20px;
                }

                .cvv-details p {
                    margin-top: 6px;
                }
                .paypal-btn,
                .proceed-btn {
                    cursor: pointer;
                    font-size: 16px;
                    width: 100%;
                    border-color: transparent;
                    border-radius: 6px;
                }

                .proceed-btn {
                    margin-bottom: 10px;
                    background: #cce5ff;
                }

                .paypal-btn a,
                .proceed-btn a {
                    text-decoration: none;
                }

                .proceed-btn a {
                    color: #000000;
                }

                .paypal-btn a {
                    color: rgba(242, 242, 242, .7);
                }

                input,button,select{
                    padding: 10px 10px;
                }

            </style>
            <div class="credit-card">
                <div class="form-header">
                    <h4 class="title">Credit card detail</h4>
                </div>

                <div class="form-body">
                    <!-- Card Number -->
                    <input type="text" maxlength="16" minlength="19" class="card-number" placeholder="Card Number">
                    <input type="text" class="card-holder" placeholder="Card Holder">
                    <!-- Date Field -->
                    <div class="date-field">
                        <div class="month">
                            <select name="Month" class="Month">
                                <option value="january">January</option>
                                <option value="february">February</option>
                                <option value="march">March</option>
                                <option value="april">April</option>
                                <option value="may">May</option>
                                <option value="june">June</option>
                                <option value="july">July</option>
                                <option value="august">August</option>
                                <option value="september">September</option>
                                <option value="october">October</option>
                                <option value="november">November</option>
                                <option value="december">December</option>
                            </select>
                        </div>
                        <div class="year">
                            <select name="Year" class="Year">
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                    </div>

                    <!-- Card Verification Field -->
                    <div class="card-verification">
                        <div class="cvv-input">
                            <input type="text" class="CVV" minlength="3" maxlength="4" placeholder="CVV">
                        </div>
                        <div class="cvv-details">
                            <p>3 or 4 digits usually found <br> on the signature strip</p>
                        </div>
                    </div>
                    <button type="submit" class="proceed-btn" onclick="addCardToUser('../model/payment_details.php')"><a >Save Card</a></button>
                    <br>
                    <div class="error-badge-card" hidden=""></div>
                </div>
                <br>
                <br>
            </div>
            <script>
            </script>

            <?php
        }
        else{
            ?>
            <div style="margin-top:30%;width:100%;padding: 10px 10px;border-radius: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.8);background:#ffffff;">
                <div class="width:100%;">
                    <img src="../img/grocery.gif" style="width:100%;" alt="">
                </div>
                <div style="width:100%;text-align:center;color:navy;display: flex;" class="sudoLoaderProcessor">
                    <img src="../img/loader.gif" style="width:70px;height: 70px;padding: 10px 10px;" alt="">
                    <span style="padding: 10px 10px;font-size: x-large;">Processing Order...</span>
                </div>
            </div>

            <?php
            $OrderPdoResultTo = $OrderPdo->CreateNewOrder($getCartItem);
            print_r($OrderPdoResultTo);

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