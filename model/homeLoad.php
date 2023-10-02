<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user_agent'],$_SESSION['var_agent'])){
    require_once("../controller/mmshightech.php");
    require_once("../controller/mmshightech/ProductsPdo.php");
    require_once("../controller/mmshightech/StorePdo.php");
    $mmshightech=new mmshightech();
    $productPdo=new ProductsPdo($mmshightech);
    $StorePdo=new StorePdo($mmshightech);
    $cur_user_row = $mmshightech->userInfo($_SESSION['user_agent']);
    if($cur_user_row['user_type']=='app'){
        date_default_timezone_set('Africa/Johannesburg');
        $getProductDiscount = $productPdo->getProductCatalogueSpecialsDetailes($cur_user_row['store_id']);
        $getStoreMenuCategoryIds = $StorePdo->getStoreMenuCategoryIds($cur_user_row['store_id'])
        ?>
        <div class="specials">
            <label>Specials</label>
            <div class="specials-display">
                <?php
                foreach ($getProductDiscount as $product){
                    if($product['discount']=="Y"){
                        $getTotalOnCart = $productPdo->getTotalOnCart($product['product_id'],$product['store_id'],$cur_user_row['id']);
                        ?>
                        <div class="row-specials">
                            <div class="special-product">
                                <div class="top-display-product">
                                    <img alt="tinfish.jpg" src="../img/tinfish.jpg">
                                    <div style="padding: 3px 4px; border-radius: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.5);">
                                        <div><i class="fa fa-plus-circle" onclick="addThisProductToCart('<?php echo $product['product_id'];?>','<?php echo $cur_user_row['id'];?>','<?php echo $product['store_id'];?>')" style="font-size:30px; " aria-hidden="true"></i></div>
                                        <div style="font-size:20px; " class="display-quantity<?php echo $product['product_id'];?>"><?php echo $getTotalOnCart;?></div>
                                        <div><i class="fa fa-minus-circle" onclick="removeThisProductFromCart('<?php echo $product['product_id'];?>','<?php echo $cur_user_row['id'];?>','<?php echo $product['store_id'];?>')" style="font-size:30px; " aria-hidden="true"></i></div>
                                    </div>

                                </div>
                                <div class="top-display-product-info" >
                                    <div style="font-size: smaller;width:100%; display:flex;">
                                        <div style="font-size: smaller;width:80%;" class="price-product">R<?php echo number_format($product['price'],'2')?></div>
                                        <div style="width:20%;">
                                            <i class="fa fa-check" style="font-size: medium;color:darkgreen;border-radius:100px;border:2px solid darkgreen;" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <p style="font-size: smaller;text-wrap:wrap;"><?php echo $product['product_description'];?></p>

                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                </div>
            </div>
        </div>
        <div class="bodySlamCategories">
            <span>Menu | Categories</span>
            <div class="menu-category">
                <?php
                foreach ($getStoreMenuCategoryIds as $data){
                    $ext = "menuId=".$data['menu_category_id']."&clientId=2&storeId=".$cur_user_row['store_id'];
                    ?>
                    <div class="menu" >
                        <div class="menu-display" onclick="NavLoader(
                            '.rollover-dash',
                            '../model/catergotyMenuSelector.php?<?php echo $ext;?>'
                            )">
                            <div class="left-menu-img">
                                <img src="../img/rice.jpg">
                            </div>
                            <div class="right-menu-img">
                                <span><?php echo $data['menu'];?></span>
                                <h6><?php echo $data['description'];?></h6>
                            </div>
                            <div class="left-menu-img">
                                <img src="../img/rice.jpg">
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }
    else{
        unset($_SESSION['user_agent'],$_SESSION['var_agent']);
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
