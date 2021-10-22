<?php
include "../header/header.php";
include "../db_con/connection.php";
if(!isset($_SESSION["clientId"]) && !isset($_SESSION["companyId"]) && empty($_SESSION["clientId"])
&& empty($_SESSION["companyId"])){
    exit();
}
?>
<head>
    <link rel="stylesheet" href="cart.css">
</head>
<h1>My Cart</h1>
<div class="cart-container">
</div>
<div>
<button id="purchase"class="btn"><a href="order.php">Complete order</a></button>
</div>
<script>
    $(document).ready(function(){
        refreshCart();
        $(".cart-container").on('click','.delete',function(){
            var parent=$(this).parent().parent();
            var id=parent.attr("id");
            var productId=$("#"+id+" .p_id").val();
            $.ajax({
           type:"POST",
           url:"../ajax/operations/removeFromCart.php",
           data:{p_id:productId},
           success:function(response){
                    refreshCart();
               }
           })
        })
        function refreshCart(){
            $.ajax({
                type:"POST",
                url:"../ajax/refresh/refreshCart.php",
                success:function(response){
                    $(".cart-container").empty();
                    if(response=="No products found in your cart"){
                    $(".cart-container").append("<h3><i>"+response+"</i></h3>");
                    $("#purchase").hide();
                    }
                    else
                    $(".cart-container").append(response);
                }
            })
        }
        
    });
</script>
<?php
include "../footer/footer.php";
?>