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
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Netchatsa SGELA is a project implemented by MMS HIGH TECH to make tertiary applications and funding applications easier, affordable and trackable. Tertiary applications, Bursary applications, NSFAS applications, Matric Upgrade, create an account and login to see more feaatures.(::By mms enterprise, netchatsa, Mr MS Mzobe) .&amp; Backups">
    <link rel="canonical" href="https://netchatsa.com/"/>
    <meta name="keywords" content="TERTIARY APPLICATIONS, MATRIC UPGRADE, SELF LEARNING, TUTORIALS, PAST EXAM PAPERS, AND LESSONS">
    <meta name="author" content="Mr M.S Mzobe,mms enterprise,netchatsa">
    <link rel='dns-prefetch' href='https://netchatsa.com//s0.wp.com' />
    <link rel='dns-prefetch' href='https://netchatsa.com/'/>
    <link rel='dns-prefetch' href='https://fonts.googleapis.com' />
    <link rel='dns-prefetch' href='https://netchatsa.com//s.w.org' />
    <link rel="alternate" type="application/rss+xml" title="The best edu-technology intergration  &raquo; Feed" href="https://netchatsa.com/feed/" />
    <link rel="alternate" type="application/rss+xml" title="The best edu-technology intergration &raquo; Comments Feed" href="https://netchatsa.com/feed/" />
    <meta property="og:title" content="netchatsa : Bringing quality education to your hands |(::By mms enterprise)|"/>
    <meta property="og:description" content="Netchatsa SGELA is a project implemented by MMS HIGH TECH to make tertiary applications and funding applications easier, affordable and trackable. Tertiary applications, Bursary applications, NSFAS applications, Matric Upgrade, create an account and login to see more feaatures. &amp; Backups"/>
    <meta property="og:.url" content="https://netchatsa.com"/>
    <meta property="og:site_name" content="Netchatsa :: The best Edu technology" />

    <link rel="icon" href="../img/logo-1933884_640.webp">
    <title>Spaza Shop</title>

<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Roboto:ital,wght@0,400;1,700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>

</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
    @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');
    *{
        margin: 0;
        padding: 0;
        font-family: 'poppins', sans-serif;
    }
    section {
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        width: 100%;
        background: #f1f1f1 center;
        background-size: cover;
    }
    .topUp-section{
        height: 92vh;
        width: 100%;

    }
    .topUp-section .rollover-dash{
        width: 100%;
        height:92%;
        padding: 15px 8px;
        overflow-y: auto;
        overflow-wrap: break-word;
        word-wrap: break-word;
        hyphens: auto;
    }
    .topUp-section .rollover-dash::-webkit-scrollbar{
        width:1px;
    }
    .topUp-section .rollover-dash::-webkit-scrollbar-thumb {
        background: #ffffff;
        border-radius: 10px;
    }
    .topUp-section .rollover-dash .specials{
        width: 100%;
        color: #11101d;
    }
    .topUp-section .rollover-dash .specials .specials-display{
        overflow-y: hidden;
        overflow-wrap: break-word;
        word-wrap: break-word;
        hyphens: auto;
        display:flex;
        width:100%;
    }
    .topUp-section .rollover-dash .specials .specials-display::-webkit-scrollbar{
        height:1px;
    }
    .topUp-section .rollover-dash .specials .specials-display::-webkit-scrollbar-thumb {
        background: #11101d;
        border-radius: 10px;
    }
    .topUp-section .order-search{
        padding: 10px 10px;
        width: 100%;
        height: 8%;
        border-bottom: #000000;
        background: #ffffff;
        box-shadow: 0 2px 3px 0 rgba(0,0,0,.5);
    }
    .topUp-section .order-search input{
        width: 100%;
        padding: 10px 10px;
        background: #ffffff;

        color: #11101d;
        border-radius: 10px;
    }

    .topDown-section{
        width: 100%;
        height: 8vh;
        position: fixed;
        padding: 10px 10px;
    }
    .topDown-section .bottom-nav{
        border-top: 2px solid #000000;
        border-left: 2px solid #000000;
        border-bottom: 2px solid #000000;
        border-right: 2px solid #000000;
        position: relative;
        width: 100%;
        height: 100%;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 3px 0 rgba(0,0,0,0.5);
    }
    .topDown-section .bottom-nav a{
        font-size: 20px;
        text-transform: uppercase;
        color: #11101d;
        text-decoration: none;
        line-height: 50px;
        position: relative;
        z-index: 1;
        display: inline-block;
        text-align: center;
    }
    .topDown-section .bottom-nav a:hover{
        color:#11101d;
    }
    .topDown-section .bottom-nav .animation{
        position: absolute;
        height: 100%;
        /* height: 5px; */
        top: 0;
        /* bottom: 0; */
        z-index: 0;
        background: #dddddd;
        border-radius: 8px;
        transition: all .5s ease 0s;
        color:#11101d;

    }
    .row-specials{
        padding: 10px 10px;
        max-width:200px;
        min-width:200px;
        height:200px;
    }
    .bodySlamCategories{
        width:100%;
        padding: 5px 0;

    }
    .bodySlamCategories span{
        font-size: 20px;
        font-style: normal;
        font-weight: bolder;
    }
    .bodySlamCategories .menu-category{
        width: 100%;
        overflow-x: auto;
        overflow-wrap: break-word;
        word-wrap: break-word;
        hyphens: auto;
    }
    .bodySlamCategories .menu-category .menu{
        width: 100%;
        padding: 10px 10px;
    }
    .bodySlamCategories .menu-category .menu .menu-display{
        width:100%;
        box-shadow: 0 2px 3px 0 rgba(0,0,0,0.9);
        display: flex;
        background: #ffffff;
    }

    .bodySlamCategories .menu-category .menu .menu-display .left-menu-img{
        width:10%;
        padding: 15px 5px;
    }
    .bodySlamCategories .menu-category .menu .menu-display .left-menu-img img{
        width:100%
    }
    .bodySlamCategories .menu-category .menu .menu-display .right-menu-img{
        width: 90%;
        padding: 5px 5px;
        text-align: center;
        /*margin-left:-30px;*/
    }
    .bodySlamCategories .menu-category .menu .menu-display .right-menu-img span{
        font-weight: bolder;
        font-style: normal;
        color: #000000;
    }
    .bodySlamCategories .menu-category .menu .menu-display .right-menu-img h6{
        font-size: x-small;
    }
    .menu-category::-webkit-scrollbar{
        width:1px;
    }
    .menu-category::-webkit-scrollbar-thumb {
        background: #ffffff;
        border-radius: 10px;
    }
    .row-specials .special-product{
        width: 100%;
        height: 100%;
        padding: 5px 5px;
        box-shadow: 0 2px 3px 0 rgba(0,0,0,0.9);
        /*border-top: 2px solid #000000;*/
        /*border-left: 2px solid #000000;*/
        /*border-bottom: 2px solid #000000;*/
        /*border-right: 2px solid #000000;*/
        background: #ffffff;
        border-radius: 10px;
    }
    .row-specials .top-display-product {
        width: 100%;
        height: 60%;
        display: flex;
        padding: 3px 0;
        color: #11101d;
    }
    .row-specials .top-display-product img{
        width: 70%;
        height: 100%;
    }
    .top-display-product-info{
        padding: 5px 0;
        color: #11101d;
    }
    .topDown-section .bottom-nav .animation:hover{
        color:#11101d;
    }
    .topDown-section .bottom-nav a:nth-child(1){
        width: 15%;
        color: #11101d;
    }
    .topDown-section .bottom-nav .start-home, a:nth-child(1):hover~.animation{
        width: 15%;
        left: 0;
        border:  2px solid  #11101d;
    }
    .topDown-section .bottom-nav a:nth-child(2){
        width: 15%;
    }
    .topDown-section .bottom-nav a:nth-child(2):hover~.animation{
        width: 15%;
        left: 62px;
        color: color:#11101d;
        border:  2px solid  #11101d;
    }
    .topDown-section .bottom-nav a:nth-child(3){
        width: 17%;
    }
    .topDown-section .bottom-nav a:nth-child(3):hover~.animation{
        width: 15%;
        left: 129px;
        color: color:#11101d;
        border:  2px solid  #11101d;
    }
    .topDown-section .bottom-nav a:nth-child(4){
        width: 15%;
    }
    .topDown-section .bottom-nav a:nth-child(4):hover~.animation{
        width: 15%;
        left: 194px;
        color: color:#11101d;
        border:  2px solid  #11101d;
    }
    .topDown-section .bottom-nav a:nth-child(5){
        width: 15%;
    }
    .topDown-section .bottom-nav a:nth-child(5):hover~.animation{
        width: 15%;
        left: 256px;
        color: color:#11101d;
        border:  2px solid  #11101d;
    }
    .topDown-section .bottom-nav a:nth-child(6){
        width: 15%;
    }
    .topDown-section .bottom-nav a:nth-child(6):hover~.animation{
        width: 15%;
        left: 320px;
        color: color:#11101d;
        border: 2px solid  #11101d;
    }
    .grouping-con{
        width:100%;
        display: flex;
    }
    .currentOrder{
        padding: 10px 10px;
        color: #000000;
        background: #2BD47D;
        font-size: large;
        font-weight: bolder;
        border-radius: 50px;
        box-shadow: 0 2px 3px 0 rgba(0,0,0,1);

    }
    .orderHistory-Display{
        width: 100%;
        padding: 10px 10px;
        border-bottom: 2px solid #000000;
        color: #000000;
        font-weight: bolder;
        font-size: medium;
    }
    .displayETA{
        width:100%;
        padding: 10px 10px;
        border-radius: 10px;
        background: dimgrey;
        box-shadow: 0 2px 3px 0 rgba(0,0,0,0.3);
        display: flex;
    }
    .displayETA .divClass-left{
        padding: 10px 10px;
        width:40%;
        font-size: large;
        color:white;
    }
    .displayETA .divClass-right{
        padding: 10px 10px;
        width: 60%;
        font-size: large;
        color:white;
    }
    .orderProgress{
        padding: 10px 10px;
        width:100%;

    }
    .orderProgress .flex-grouping{
        width:100%;
        padding: 10px 10px;
        display: flex;
        border-radius: 50px;

    }
    .text-none-display{
        color:#dddddd;
    }
    .isStatusTrue{
        box-shadow: 0 2px 3px 0 rgba(0,0,0,0.7);
        color:#000000;
    }

    .orderProgress .flex-grouping .timeDisplay{
        padding: 0 10px;

    }
</style>
<body>
<section>
    <div class="topUp-section">
        <div class="order-search">
            <input class="search-products" id="search-products" type="search" oninput="searchFindProducts()" placeholder="Search product ....">
        </div>
        <div class="rollover-dash" id="rollover-dash"></div>
    </div>
    <div class="topDown-section">

        <nav class="bottom-nav">
           <a> <i onclick="NavLoader('.rollover-dash','../model/homeLoad.php?start=0&limit=10')" class="fa fa-home" aria-hidden="true"></i></a>
            <a><i onclick="NavLoader('.rollover-dash','../model/cart.php?store_id=2')" class="fa fa-cart-plus" aria-hidden="true"></i><sup style="font-size: small;color:red;" class="cart-model-size">0</sup></a>
            <a><i onclick="NavLoader('.rollover-dash','../model/orderHistory.php?start=0&limit=10')" class="fa fa-history" aria-hidden="true"></i></a>
            <a><i onclick="NavLoader('.rollover-dash','../model/creditCard.php')" class="fa fa-credit-card" aria-hidden="true"></i></a>
            <a><i onclick="NavLoader('.rollover-dash','../model/settings.php')" class="fa fa-cog" aria-hidden="true"></i></a>
            <a><i onclick="menuBar()" class="fa fa-bars" aria-hidden="true"></i></a>
            <div class="animation start-home"></div>
        </nav>
    </div>
</section>

<div id="outOfStockModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="text-align: center;font-weight: bolder;color: #000000;">OUT OF STOCK ITEMS ALERT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="padding: 10px 10px;color:red;">
                    Sorry, Some Items are out of stock. Please find alternatives or remove them from your cart.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        NavLoader(".rollover-dash","../model/homeLoad.php?start=0&limit=10");
        getCart('<?php echo $cur_user_row['id']?>','<?php echo $cur_user_row['store_id']?>');
    });
    function outOfStockItemsWarning(id){
        $(id).modal('show');
    }
    function NavLoader(ObjClass,NavPath){ //save history
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{ObjClass:ObjClass,NavPath:NavPath},
            cache:false,
            success:function(e){
                if(e.length===1){
                    loadAfterQuery(".rollover-dash",NavPath);
                }
                else{
                    console.log(e);
                }
            }
        });
    }
    function navigateBack(prev_id_back_nav,obj_class_back_nav,url_back_nav){
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{prev_id_back_nav:prev_id_back_nav,obj_class_back_nav:obj_class_back_nav,url_back_nav:url_back_nav},
            cache:false,
            success:function(e){
                if(e.length===1){
                    console.log(e);
                    loadAfterQuery(".rollover-dash",url_back_nav);
                }
                else{
                    console.log(e);
                }
            }
        });

    }
    function setAddress(){
        const DeliveryAddress = $(".pac-input").val();
        $(".setAddress").html("processing...");
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{DeliveryAddress:DeliveryAddress},
            cache:false,
            success:function(e){
                if(e.length==1){
                    $(".setAddress").html("Address set success. please wait...");
                    NavLoader(
                        '.rollover-dash',
                        '../model/checkout.php?price=true'
                    );
                }
                else{
                    $(".setAddress").html(e);


                }
            }
        });
    }
    function loadAfterQuery(classId,url){
        $(classId).html("<center><img src='../img/loader.gif' style='width:30%;padding:10px 10px;justify-content:center;align-content:center;text-align:center;'></center>").load(url);
    }
    function removeThisProductFromCart(product_id_reduce,user_id_reduce,store_uid_reduce){
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{product_id_reduce:product_id_reduce,user_id_reduce:user_id_reduce,store_uid_reduce:store_uid_reduce},
            cache:false,
            success:function(e){
                if(e.length>3){
                    $(".display-quantity"+product_id_reduce).html(e);
                }
                else if(e.length==2){
                    getCart(user_id_reduce,store_uid_reduce);
                    NavLoader('.rollover-dash','../model/cart.php?store_id='+store_uid_reduce);
                }
                else{
                    $(".display-quantity"+product_id_reduce).html(e);
                    getCart(user_id_reduce,store_uid_reduce);


                }
            }
        });
    }
    function  getCart(user_id_cart,store_uid_cart){
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{user_id_cart:user_id_cart,store_uid_cart:store_uid_cart},
            cache:false,
            success:function(e){
                if(e.length>3){
                    $(".cart-model-size").html(e.replace(/['"]+/g, ""));
                }
                else{
                    $(".cart-model-size").html(e.replace(/['"]+/g, ""));
                }
            }
        });
    }
    function addThisProductToCart(product_id,user_id,store_uid){
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{product_id:product_id,user_id:user_id,store_uid:store_uid},
            cache:false,
            success:function(e){
                if(e.length>3){
                    $(".display-quantity"+product_id).html(e);
                }
                else{
                    $(".display-quantity"+product_id).html(e);
                    getCart(user_id,store_uid);
                }
            }
        });
    }
    function searchFindProducts(){
        var search = document.getElementById("search-products").value;
        console.log(search);
        if(search===""){
            loadAfterQuery(".rollover-dash","../model/homeLoad.php?start=0&limit=10");
        }
        else{
            const url="../model/SearchCatalogue.php";
            $.ajax({
                url:url,
                type:"POST",
                data:{search:search},
                cache:false,
                success:function(e){
                    document.getElementById("rollover-dash").innerHTML = e;
                }
            });
        }
    }
    function setUserCreditActive(CreditStatus){
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{CreditStatus:CreditStatus},
            cache:false,
            success:function(e){
                console.log(e);
                if(e.length===1){
                    NavLoader(
                        '.rollover-dash',
                        '../model/checkout.php?price=true');
                }
                else{
                    $(".errorToggleShowaa").removeAttr("hidden").attr("style","color:red;padding:2px 2px;font-size:x-smaller;").html(e);
                }
            }
        });
    }
    function proceedToPayment(){
        const rollOverOrderFromCheckout = $(".rollOverOrder").val();
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{rollOverOrderFromCheckout:rollOverOrderFromCheckout},
            cache:false,
            success:function(e){
                console.log(e);
                if(e.length===1){
                    NavLoader(
                        '.rollover-dash',
                        '../model/checkout.php?price=true');
                }
                else{
                    $(".errorToggleShow").removeAttr("hidden").attr("style","color:red;padding:2px 2px;font-size:x-smaller;").html(e);
                }
            }
        });
    }
    function cancelOrderFromCart(user_id,store_uid){
        const CancelOrderFromCart = "C";
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{CancelOrderFromCart:CancelOrderFromCart},
            cache:false,
            success:function(e){
                console.log(e);
                if(e.length===1){
                    NavLoader(".rollover-dash","../model/homeLoad.php?start=0&limit=10");
                    getCart(user_id,store_uid);
                }
                else{
                    $(".cancelOrderFromCart").attr("style","color:red;padding:2px 2px;font-size:x-smaller;").html(e);
                }
            }
        });

    }
    function deliveryStatusCall(DeliveryStatus){
        // console.log(DeliveryStatus);
        const DeleveryStatusValue = (DeliveryStatus==='Delivery')?'Collection':"Delivery";
        // console.log("t be saved : "+DeleveryStatusValue);
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{DeleveryStatusValue:DeleveryStatusValue},
            cache:false,
            success:function(e){
                console.log(e);
                if(e.length===1){
                    NavLoader(
                        '.rollover-dash',
                        '../model/checkout.php?price=true');
                }
                else{
                    $(".errorToggleShow").removeAttr("hidden").attr("style","color:red;padding:5px 5px;font-size:x-smaller;").html(e);
                }
            }
        });
    }
    function addPromoCode(){
        const newPromoCode = $(".PromoCode").val();
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{newPromoCode:newPromoCode},
            cache:false,
            success:function(e){
                console.log(e);
                if(e.length===1){
                    $('.PromoCode').attr("disabled","true");
                    $('.addPromoCode').attr("disabled","true");
                    $(".errorPackPromo").removeAttr("hidden").attr("style","color:green;padding:2px 2px;").html('Promo Activated');
                    $(".PromoCode").val('');
                }
                else{
                    $(".errorPackPromo").removeAttr("hidden").attr("style","color:red;padding:2px 2px;").html(e.replace(/['"]+/g, ''));
                }
            }
        });
    }
    function checkedTip(DriverTipPercentage){
        $.ajax({
            url:"../controller/mmshightech/processor.php",
            type:"POST",
            data:{DriverTipPercentage:DriverTipPercentage},
            cache:false,
            success:function(e){
                console.log(e);
                if(e.length===1){
                    NavLoader(
                        '.rollover-dash',
                        '../model/checkout.php?price=true');

                }
                else{
                    $(".errorDisplayDriverTip").removeAttr("hidden").attr("style","color:red;padding:2px 2px;").html(e.replace(/['"]+/g, ''));
                }
            }
        });
    }
    function addCardToUser(dir){
        $(".error-badge-card").removeAttr("hidden").attr("style","color:green;").html('Processing Data...');
        const cardnumber=$(".card-number").val();
        const cardholder=$(".card-holder").val();
        const cvv=$(".CVV").val();
        const year=$(".Year").val();
        const month=$(".Month").val();
        $(".card-number").removeAttr("style");
        $(".card-holder").removeAttr("style");
        $(".CVV").removeAttr("style");
        $(".Year").removeAttr("style");
        $(".Month").removeAttr("style");
        if(cardnumber.length===0){
            $(".error-badge-card").removeAttr("hidden").attr("style","color:red;").html('Field required!');
            $(".card-number").attr("style","border:2px solid red");
        }
        else if(cardholder.length===0){
            $(".error-badge-card").removeAttr("hidden").attr("style","color:red;").html('Field required!');
            $(".card-holder").attr("style","border:2px solid red");
        }
        else if(cvv.length===0){
            $(".error-badge-card").removeAttr("hidden").attr("style","color:red;").html('Field required!');
            $(".CVV").attr("style","border:2px solid red");
        }
        else if(year.length===0){
            $(".error-badge-card").removeAttr("hidden").attr("style","color:red;").html('Field required!');
            $(".Year").attr("style","border:2px solid red");
        }
        else if(month.length===0){
            $(".error-badge-card").removeAttr("hidden").attr("style","color:red;").html('Field required!');
            $(".Month").attr("style","border:2px solid red");
        }
        else{
            $.ajax({
                url:"../controller/mmshightech/processor.php",
                type:"POST",
                data:{cardnumber:cardnumber,cardholder:cardholder,cvv:cvv,year:year,month:month},
                cache:false,
                success:function(e){
                    if(e.length===1){
                        console.log(dir);
                        NavLoader(
                            '.rollover-dash',
                            dir);

                    }
                    else{
                        $(".errorDisplayDriverTip").removeAttr("hidden").attr("style","color:red;padding:2px 2px;").html(e.replace(/['"]+/g, ''));
                    }
                }
            });
        }
    }
</script>
</body>
</html>
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
