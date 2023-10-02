<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user_agent'],$_SESSION['var_agent'])){
    require_once("../controller/mmshightech.php");
    $mmshightech=new mmshightech();
    $cur_user_row = $mmshightech->userInfo($_SESSION['user_agent']);
    if($cur_user_row['user_type']=='app'){
        date_default_timezone_set('Africa/Johannesburg');
        if(isset($_GET['OrderId'])){
            $orderInfo = ['order'];
            ?>
            <div class="displayETA">
                <div class="divClass-left">
                    <div class="text-fit">ORDER NO.</div>
                    <div class="text-fit">14526563</div>
                </div>
                <div class="divClass-right">
                    <div class="text-fit">DELIVERY TIME</div>
                    <div class="text-fit">
                        Today
                        <i class="fa fa-star" style="font-size: x-small;color:blue;" aria-hidden="true"></i>
                        13:50 <i class="fa fa-star" style="font-size: x-small;color:blue;" aria-hidden="true"></i> 14:50
                    </div>
                </div>
            </div>
            <h3 style="color:#000000;font-weight: bolder;">Order Progress</h3>
            <div class="orderProgress">
                <div class="orderStatusLeft">
                    <div class="flex-grouping isStatusTrue">
                        <div class="timeDisplay">14:56
                            <i class="fa fa-check-circle" style="font-size: medium;color:darkgreen;" aria-hidden="true"></i>
                        </div>
                        <div class="StatusDisplay">
                            <span>Order Placed</span>
                        </div>
                    </div>
                    <br>
                    <div class="flex-grouping text-none-display">
                        <div class="timeDisplay">14:56
                            <i class="fa fa-circle" style="font-size: medium;color:#dddddd;" aria-hidden="true"></i>
                        </div>
                        <div class="StatusDisplay">
                            <span>Store Accepted Order</span>
                        </div>
                    </div>
                    <br>
                    <div class="flex-grouping text-none-display">
                        <div class="timeDisplay">14:56
                            <i class="fa fa-circle" style="font-size: medium;color:#dddddd;" aria-hidden="true"></i>
                        </div>
                        <div class="StatusDisplay">
                            <span>Store Processing Order</span>
                        </div>
                    </div>
                    <br>
                    <div class="flex-grouping text-none-display">
                        <div class="timeDisplay">14:56
                            <i class="fa fa-circle" style="font-size: medium;color:#dddddd;" aria-hidden="true"></i>
                        </div>
                        <div class="StatusDisplay">
                            <span>Driver Notified, Way to Store</span>
                        </div>
                    </div>
                    <br>
                    <div class="flex-grouping text-none-display ">
                        <div class="timeDisplay">14:56
                            <i class="fa fa-circle" style="font-size: medium;color:#dddddd;" aria-hidden="true"></i>
                        </div>
                        <div class="StatusDisplay">
                            <span>Driver Waiting @Store</span>
                        </div>
                    </div>
                    <br>
                    <div class="flex-grouping text-none-display">
                        <div class="timeDisplay">14:56
                            <i class="fa fa-circle" style="font-size: medium;color:#dddddd;" aria-hidden="true"></i>
                        </div>
                        <div class="StatusDisplay">
                            <span>Driver on his way to you</span>
                        </div>
                    </div>
                    <br>
                    <div class="flex-grouping text-none-display">
                        <div class="timeDisplay">14:56
                            <i class="fa fa-circle" style="font-size: medium;color:#dddddd;" aria-hidden="true"></i>
                        </div>
                        <div class="StatusDisplay">
                            <span>Driver Arrived</span>
                        </div>
                    </div>
                    <br>
                    <div class="flex-grouping text-none-display">
                        <div class="timeDisplay">14:56
                            <i class="fa fa-circle" style="font-size: medium;color:#dddddd;" aria-hidden="true"></i>
                        </div>
                        <div class="StatusDisplay">
                            <span>Order Delivered</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="details-order" style="padding 10px 10px;text-align: center;align-content: center;justify-items: center;display: flex;">
                <div class="div-setter" style="padding:10px 10px; width:50%;">
                    <span onclick="" class="badge badge-secondary text-center text-white"
                          style="text-align: center;padding: 10px 10px;">View Order</span>
                </div>
                <div class="div-setter" style="text-align: center;padding: 10px 10px;">
                    <span class="badge badge-dark text-center text-white"
                          style="text-align: center;padding: 10px 10px;">Contact Us</span>
                </div>

            </div>

            <?php
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
