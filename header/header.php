<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../header/headerStyle.css"/>
</head>
<body>
    <div class="container">
        <div class="client-options">
            <ul>
                <a href="../user_profile/profile.php"><li>View my profile</li></a>
                <a href="../register_login/logout.php"><li>Logout</li></a>
        </div>
    
        <div class="navbar">
            <img src="../imgs/capture.png">
            
            <ul id="menu1">
                <li><a href="../home/home.php">Home</a></li>
                <li class="categorie">
                    <a href="#">Categories</a>
                    <ul class="categorie-list">
                <?php 
                    include "../db_con/connection.php";
                    $allCategories="select categoryName,categoryId from categories";
                    $result=mysqli_query($con,$allCategories);
                    while($row=mysqli_fetch_assoc($result)){
                        echo "<a href=\"../products/viewProducts.php?i=".$row["categoryId"]."\"><li>".$row["categoryName"]."</li></a>";
                    }
                ?>
                 </ul>
                </li>
            <li><a href="../contact/contactUs.php">Contact Us</a></li>
            <?php
                if(isset($_SESSION["companyId"]) && !empty($_SESSION["companyId"])){
                    echo "<li><a href=\"../add_product/addProduct.php\">Add a product</li>";
                    echo "<li><a href=\"../products/companyViewProduct.php\">View my products</li>";
                }
            ?>
                <hr>
            </ul>
                <div class="mob-btn">
                    <?php
                    if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"])
                    || isset($_SESSION["companyId"]) && !empty($_SESSION["companyId"])){
                    echo "<div><a href=\"../user_profile/profile.php\">View my account</a></div>";
                    echo "<div><a href=\"../cart/cart.php\">My cart</a></div>";
                    echo "<div><a href=\"../register_login/logout.php\">Log out</a></div>";
                    }
                    else{
                        echo "<div><a href=\"../register_login/register.php\">Register a new account</a></div>";
                    }
                    ?>
                </div>
            <table class="tab">
                <tr>
                <form method="POST" action="../search/searchPage.php">    
                <td><input type="text" name="search" placeholder="Search..."/></td>
                <td><button type="submit"><i class="fas fa-search"></i>&nbsp;&nbsp;<span id="searchText"></span></button></td> 
                <td class="icon-style">
                <?php
                if(isset($_SESSION["clientName"]) && !empty($_SESSION["clientName"])){
                    echo "<i class=\"fas fa-user-circle icon-click\"></i><span class=\"icon-click\">".$_SESSION["clientName"]."</span></td>";
                    echo "<td class=\"icon-style\"><i class=\"fas fa-shopping-cart\"></i><span><a href=\"../cart/cart.php\">Cart</a></span></td>";
                }
                else if(isset($_SESSION["companyName"]) && !empty($_SESSION["companyName"])){
                    echo "<i class=\"fas fa-building icon-click\"></i><span class=\"icon-click\">".$_SESSION["companyName"]."</span></td>";
                    echo "<td class=\"icon-style\"><i class=\"fas fa-shopping-cart\"></i><span><a href=\"../cart/cart.php\">Cart</a></span></td>";
                }
                else{
                    echo "<a href=\"../register_login/register.php\"><i class=\"fas fa-user-circle icon-style\"></i>
                    <span class=\"reg-log\">Register/Login</span></a>";    
                echo "</td>";
                }
               ?>    
               </form>          
                </tr>       
            </table>
            <div class="mobile-menu">
            <i class="fas fa-bars"></i>
            </div>
        </div>
    </div>
 <script>
        var cat_clicks=0,client_options_clicks=0;
       $(document).ready(function(){
            $(".categorie").click(function() {
                if(cat_clicks%2==0){
                $(".categorie-list").show();
                $(".categorie").css("background-color","#2566c2");
                cat_clicks++;
                }
                else{
                    $(".categorie-list").hide();
                    $(".categorie").css("background-color","#4e97fd");
                    cat_clicks++;
                }
            });
            $(".icon-click").click(function() {
                if(client_options_clicks%2==0){
                $(".client-options").show();
                client_options_clicks++;
                }
                else{
                    $(".client-options").hide();
                    client_options_clicks++;
                }
            }
            );
            /*MOBILE PARTS*/ 
           $(".mobile-menu").click(function(){
               $(".navbar ul").toggle();
               $(".tab").toggle();
               $(".mob-btn").toggle();
           });
           
           $( window ).resize(function() {
        if($(window).width()>=1100){
            $(".navbar ul").show();
            $(".tab").show();
        }
        if($(window).width()<700){
            $(".categorie-list").css("position","static");
        }
        else{
            $(".categorie-list").css("position","absolute");
        }
                  
       })
       }
       );

    </script>
