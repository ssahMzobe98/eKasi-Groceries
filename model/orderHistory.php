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
        if(isset($_GET['start'],$_GET['limit'])){
            $backNavigation = $StorePdo->backStoreNavigation($cur_user_row['id']);?>
            <div class="tag-body-con">
                <span style="color:#000000;font-size: large;font-weight: bolder;padding: 15px 15px;">Order History</span>
                <span style="color:#000000;font-size: large;font-weight: bolder;padding: 15px 15px;"><i onclick="navigateBack('<?php echo $backNavigation['prev_id'];?>','<?php echo $backNavigation['obj_class'];?>','<?php echo $backNavigation['url'];?>')" class="fa fa-arrow-left" aria-hidden="true"></i></span>
            </div>

            <div class="currentOrder" onclick="loadAfterQuery('.rollover-dash','../model/myOrder.php?OrderId=42342342')">
                <span>Current Order  <i class="fa fa-star" style="font-size: x-small;color:blue;" aria-hidden="true"></i> 145525855
                    <i class="fa fa-star" style="font-size: x-small;color:blue;" aria-hidden="true"></i> 15 Nov 2023</span>
            </div>
            <div class="orderHistory-Display">

            </div>
            <div class="orderHistory-Display" onclick="loadAfterQuery('.rollover-dash','../model/viewOrder.php?OrderId=42342342')">
                <span>15 Nov 2023 <i class="fa fa-star" style="font-size: x-small;color:blue;" aria-hidden="true"></i> 145525855 (Delivered) <span class="badge badge-primary text-white text-center" style="font-weight: bolder;font-size: medium; color:white;">R153.25</span></span>
            </div>
            <div class="orderHistory-Display" onclick="loadAfterQuery('.rollover-dash','../model/viewOrder.php?OrderId=42342342')">
                <span>15 Nov 2023 <i class="fa fa-star" style="font-size: x-small;color:blue;" aria-hidden="true"></i> 145525855 (Delivered) <span class="badge badge-primary text-white text-center" style="font-weight: bolder;font-size: medium; color:white;">R153.25</span></span>
            </div>
            <div class="orderHistory-Display" onclick="loadAfterQuery('.rollover-dash','../model/viewOrder.php?OrderId=42342342')">
                <span>15 Nov 2023 <i class="fa fa-star" style="font-size: x-small;color:blue;" aria-hidden="true"></i> 145525855 (Delivered) <span class="badge badge-primary text-white text-center" style="font-weight: bolder;font-size: medium; color:white;">R153.25</span></span>
            </div>
            <div class="orderHistory-Display" onclick="loadAfterQuery('.rollover-dash','../model/viewOrder.php?OrderId=42342342')">
                <span>15 Nov 2023 <i class="fa fa-star" style="font-size: x-small;color:blue;" aria-hidden="true"></i> 145525855 (Delivered) <span class="badge badge-primary text-white text-center" style="font-weight: bolder;font-size: medium; color:white;">R153.25</span></span>
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
