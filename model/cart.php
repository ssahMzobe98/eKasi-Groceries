<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user_agent'],$_SESSION['var_agent'])){
    require_once("../controller/mmshightech.php");
    require_once("../controller/mmshightech/StorePdo.php");
    require_once("../controller/mmshightech/processorNewDao.php");
    require_once ("../controller/mmshightech/Constants/Constants.php");
    $mmshightech=new mmshightech();
    $StorePdo = new StorePdo($mmshightech);
    $processorNewDao = new processorNewDao($mmshightech,new Constants());
    $cur_user_row = $mmshightech->userInfo($_SESSION['user_agent']);
    if($cur_user_row['user_type']=='app'){
        date_default_timezone_set('Africa/Johannesburg');
        if(isset($_GET['store_id'])){
            $store_id = $mmshightech->cleanAll([$_GET['store_id']]);
            $backNavigation = $StorePdo->backStoreNavigation($cur_user_row['id']);
            $getCartItem = $processorNewDao->getCartDetails($cur_user_row['id'],$cur_user_row['store_id']);
            $finalProdItems=[];
            $row = [];
            $count = 0;
            $totalPrice = 0;
            foreach ($getCartItem as $item) {
                $row[]=$item;
                $totalPrice += ($item['price']*$item['quantity']);
                if(count($row)==2){
                    $finalProdItems[] = $row;
                    unset($row);
                    $row = [];
                }
                $count++;
                if($count ==count($getCartItem) and $count%2==1){
                    $finalProdItems[] = $row;
                    unset($row);
                    $row = [];
                }

            }
            $outOfStock = 0;
            if($getCartItem){
                $getCartItem['price']=$totalPrice;
                $url = "price=".$totalPrice;
                ?>
                <div class="tag-body-con">
                    <span style="color:#000000;font-size: medium;font-weight: bolder;padding: 0 10px;">Products on Cart</span>
                    <span style="color:#000000;font-size: medium;font-weight: bolder;padding: 0 10px;"><i onclick="navigateBack('<?php echo $backNavigation['prev_id'];?>','<?php echo $backNavigation['obj_class'];?>','<?php echo $backNavigation['url'];?>')" class="fa fa-arrow-left" aria-hidden="true"></i></span>
                    <span class="badge badge-success text-white text-center outofStock"
                          style="background-color:darkgreen;text-align: center;color: white;padding:10px 10px;" onclick="NavLoader(
                        '.rollover-dash',
                        '../model/checkout.php?<?php echo $url;?>'
                        )">Checkout: R<?php echo number_format($totalPrice,2);?>
                    </span>
                </div>
                <?php
                foreach ($finalProdItems as $product){
                        ?>
                    <div class="grouping-con">
                    <?php
                    foreach ($product as $row){
                        if($row['is_instock']==="N"){
                            $outOfStock++;
                        }
                        ?>
                        <div class="row-specials"   >
                            <div class="special-product" <?php if($row['is_instock']==="N"){echo 'style="background:#dddddd;opacity:.5;"';}?> >
                                <div class="top-display-product">
                                    <img alt="tinfish.jpg" src="../img/tinfish.jpg">
                                    <div style="padding: 3px 4px; border-radius: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.5);">
                                        <div><i class="fa fa-plus-circle" onclick="addThisProductToCart('<?php echo $row['product_id'];?>','<?php echo $cur_user_row['id'];?>','<?php echo $row['store_id'];?>')" style="font-size:30px; " aria-hidden="true"></i></div>
                                        <div style="font-size:20px; " class="display-quantity<?php echo $row['product_id'];?>"><?php echo $row['quantity'];?></div>
                                        <div><i class="fa fa-minus-circle" onclick="removeThisProductFromCart('<?php echo $row['product_id'];?>','<?php echo $cur_user_row['id'];?>','<?php echo $row['store_id'];?>')" style="font-size:30px; " aria-hidden="true"></i></div>
                                    </div>

                                </div>
                                <div class="top-display-product-info" >
                                    <div style="font-size: smaller;width:100%; display:flex;">
                                        <div style="font-size: smaller;width:80%;" class="price-product">R<?php echo number_format($row['price'],'2')?></div>
                                        <div style="width:20%;">
                                            <?php if($row['is_instock']==="Y"){
                                                echo '<i class="fa fa-check" style="font-size: medium;color:darkgreen;border-radius:100px;border:2px solid darkgreen;" aria-hidden="true"></i>';
                                            }
                                            else{
                                                echo '<i class="fa fa-times-circle" style="font-size: medium;color:red;border-radius:100px;border:2px solid red;" aria-hidden="true"></i>';
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <p style="font-size: smaller;text-wrap:wrap;"><?php echo $row['product_description'];?></p>

                            </div>
                        </div>

                        <?php
                    }

                    ?>
                    </div>

                    <?php
                }
                if($outOfStock>0){
                    ?>
                    <script>
                        $(".outofStock").removeAttr("onclick").attr("onclick","outOfStockItemsWarning('#outOfStockModal');");
                        outOfStockItemsWarning('#outOfStockModal');
                    </script>
                    <?php
                }

            }
            else{
                echo"<h4 style='width: 100%;color: #000000;padding: 10px 10px;text-align: center;'>
                        CART EMPTY
                    </h4>";
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
