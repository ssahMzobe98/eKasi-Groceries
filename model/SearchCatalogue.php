<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user_agent'],$_SESSION['var_agent'])){
    require_once ("../controller/mmshightech/SearchCataloguePdo.php");
    require_once("../controller/mmshightech.php");
    $mmshightech=new mmshightech();
    $SearchCataloguePdo = new SearchCataloguePdo($mmshightech);
    $cur_user_row = $mmshightech->userInfo($_SESSION['user_agent']);
    if($cur_user_row['user_type']=='app'){
        date_default_timezone_set('Africa/Johannesburg');
        if(isset($_POST['search'])){
            $search = $mmshightech->OMO($_POST['search']);
            $SearchCatalogue = $SearchCataloguePdo->SearchCatalogue($search);
            if(empty($SearchCatalogue)){
                ?>
                <div class="tag-body-con">
                    <span style="color:#000000;font-size: medium;font-weight: bolder;padding: 0 10px;">Category Name here</span>
                    <span style="color:#000000;font-size: medium;font-weight: bolder;padding: 0 10px;"><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
                </div>
                <div class="grouping-con">
                    <div class="row-specials">
                        <div class="special-product">
                            <div class="top-display-product">
                                <img alt="tinfish.jpg" src="../img/tinfish.jpg">
                                <div style="padding: 3px 4px; border-radius: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.5);">
                                    <div><i class="fa fa-plus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                    <div style="font-size:20px; ">22</div>
                                    <div><i class="fa fa-minus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                </div>

                            </div>
                            <div class="top-display-product-info" >
                                <div style="font-size: smaller;width:100%; display:flex;">
                                    <div style="font-size: smaller;width:80%;" class="price-product">R1222.00</div>
                                    <div style="width:20%;">
                                        <i class="fa fa-check" style="font-size: medium;color:darkgreen;border-radius:100px;border:2px solid darkgreen;" aria-hidden="true"></i></div>
                                </div>
                            </div>
                            <p style="font-size: smaller;text-wrap:wrap;">fsdjhk fdsjkdsj kfsdfjd lkkjls dflsdj</p>

                        </div>
                    </div>
                    <div class="row-specials">
                        <div class="special-product">
                            <div class="top-display-product">
                                <img alt="tinfish.jpg" src="../img/tinfish2.jpg">
                                <div style="padding: 3px 4px; border-radius: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.5);">
                                    <div><i class="fa fa-plus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                    <div style="font-size:20px; ">22</div>
                                    <div><i class="fa fa-minus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                </div>

                            </div>
                            <div class="top-display-product-info" >
                                <div style="font-size: smaller;width:100%; display:flex;">
                                    <div style="font-size: smaller;width:80%;" class="price-product">R1222.00</div>
                                    <div style="width:20%;">
                                        <i class="fa fa-check" style="font-size: medium;color:darkgreen;border-radius:100px;border:2px solid darkgreen;" aria-hidden="true"></i></div>
                                </div>
                            </div>
                            <p style="font-size: smaller;text-wrap:wrap;">fsdjhk fdsjkdsj kfsdfjd lkkjls dflsdj</p>

                        </div>
                    </div>
                </div>
                <div class="grouping-con">
                    <div class="row-specials">
                        <div class="special-product">
                            <div class="top-display-product">
                                <img alt="tinfish.jpg" src="../img/tinfish.jpg">
                                <div style="padding: 3px 4px; border-radius: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.5);">
                                    <div><i class="fa fa-plus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                    <div style="font-size:20px; ">22</div>
                                    <div><i class="fa fa-minus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                </div>

                            </div>
                            <div class="top-display-product-info" >
                                <div style="font-size: smaller;width:100%; display:flex;">
                                    <div style="font-size: smaller;width:80%;" class="price-product">R1222.00</div>
                                    <div style="width:20%;">
                                        <i class="fa fa-check" style="font-size: medium;color:darkgreen;border-radius:100px;border:2px solid darkgreen;" aria-hidden="true"></i></div>
                                </div>
                            </div>
                            <p style="font-size: smaller;text-wrap:wrap;">fsdjhk fdsjkdsj kfsdfjd lkkjls dflsdj</p>

                        </div>
                    </div>
                    <div class="row-specials">
                        <div class="special-product">
                            <div class="top-display-product">
                                <img alt="tinfish.jpg" src="../img/rice2.jpg">
                                <div style="padding: 3px 4px; border-radius: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.5);">
                                    <div><i class="fa fa-plus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                    <div style="font-size:20px; ">22</div>
                                    <div><i class="fa fa-minus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                </div>

                            </div>
                            <div class="top-display-product-info" >
                                <div style="font-size: smaller;width:100%; display:flex;">
                                    <div style="font-size: smaller;width:80%;" class="price-product">R1222.00</div>
                                    <div style="width:20%;">
                                        <i class="fa fa-check" style="font-size: medium;color:darkgreen;border-radius:100px;border:2px solid darkgreen;" aria-hidden="true"></i></div>
                                </div>
                            </div>
                            <p style="font-size: smaller;text-wrap:wrap;">fsdjhk fdsjkdsj kfsdfjd lkkjls dflsdj</p>

                        </div>
                    </div>
                </div>
                <div class="grouping-con">
                    <div class="row-specials">
                        <div class="special-product">
                            <div class="top-display-product">
                                <img alt="tinfish.jpg" src="../img/rice.jpg">
                                <div style="padding: 3px 4px; border-radius: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.5);">
                                    <div><i class="fa fa-plus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                    <div style="font-size:20px; ">22</div>
                                    <div><i class="fa fa-minus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                </div>

                            </div>
                            <div class="top-display-product-info" >
                                <div style="font-size: smaller;width:100%; display:flex;">
                                    <div style="font-size: smaller;width:80%;" class="price-product">R1222.00</div>
                                    <div style="width:20%;">
                                        <i class="fa fa-check" style="font-size: medium;color:darkgreen;border-radius:100px;border:2px solid darkgreen;" aria-hidden="true"></i></div>
                                </div>
                            </div>
                            <p style="font-size: smaller;text-wrap:wrap;">fsdjhk fdsjkdsj kfsdfjd lkkjls dflsdj</p>

                        </div>
                    </div>
                    <div class="row-specials">
                        <div class="special-product">
                            <div class="top-display-product">
                                <img alt="tinfish.jpg" src="../img/rice2.jpg">
                                <div style="padding: 3px 4px; border-radius: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.5);">
                                    <div><i class="fa fa-plus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                    <div style="font-size:20px; ">22</div>
                                    <div><i class="fa fa-minus-circle" style="font-size:30px; " aria-hidden="true"></i></div>
                                </div>

                            </div>
                            <div class="top-display-product-info" >
                                <div style="font-size: smaller;width:100%; display:flex;">
                                    <div style="font-size: smaller;width:80%;" class="price-product">R1222.00</div>
                                    <div style="width:20%;">
                                        <i class="fa fa-check" style="font-size: medium;color:darkgreen;border-radius:100px;border:2px solid darkgreen;" aria-hidden="true"></i></div>
                                </div>
                            </div>
                            <p style="font-size: smaller;text-wrap:wrap;">fsdjhk fdsjkdsj kfsdfjd lkkjls dflsdj</p>

                        </div>
                    </div>
                </div>
                <?php
            }else{
                echo"<h4 style='width: 100%;background: red;color: #EFEEF1;padding: 10px 10px;text-align: center;'>
                        NO SEARCH RESULTS!!
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
