<?php
include "../header/header.php";
include "../db_con/connection.php";
$user="";
$discount="";
//CALCUL DU DISCOUNT
if(!isset($_SESSION["clientId"]) && empty($_SESSION["clientId"]) && !isset($_SESSION["companyId"]) && empty($_SESSION["companyId"])){
    exit();
}
if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"])){
    $user=$_SESSION["clientId"];
    //trouver discount
    $requete="select discount from clients where clientId=".$user;
    $result=mysqli_query($con,$requete);
    $row=mysqli_fetch_assoc($result);
    $discount=$row["discount"];
}

if(isset($_SESSION["companyId"]) && !empty($_SESSION["companyId"])){
    $user=$_SESSION["companyId"];
    //trouver discount
    $requete="select discount from company where companyId=".$user;
    $result=mysqli_query($con,$requete);
    $row=mysqli_fetch_assoc($result);
    $discount=$row["discount"];
}

?>
<head>
    <link rel="stylesheet" href="orderStyle.css">
</head>
<div class="order-container">
    <div class="order">
    <h1>Order details</h1>
    <div class="error"></div>
    <span class="spans">Email</span>
    <span class="spans"><input type="email" name="email" id="email" class="input"/></span>
    <span class="spans">City</span>
    <span class="spans">    
    <select id="city" name="city" class="input">
        <?php 
            $allCategories="select city from location";
            $result=mysqli_query($con,$allCategories);
            while($row=mysqli_fetch_assoc($result)){
             echo "<option value=".$row["city"].">".$row["city"]."</option>";
                    }
                ?>
        </select></span>
    <span class="spans">Full adress</span>
    <span class="spans"><input type="text" name="adress" id="adress" class="input"/></span>
        <span class="spans">
        <input type="button" id="order" value="Order"/>
        </span>
</div>
<div class="cart-details">
<h3>Your cart</h3>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Product Price ($)</th>
            <th>Product Price (LL)</th>
        </tr>
    <?php
        $somme=0;
        //recuperer les informations de la cart de l'utilisateur
        $requete="select productId,productQtNeeded from cart where userId=$user";
        $result=mysqli_query($con,$requete);
        while($row=mysqli_fetch_assoc($result)){
            //recuperer pour chaque produit de la cart son nom et son prix
            $requete2="select productName,productPrice from products where productId=".$row["productId"];
            $result2=mysqli_query($con,$requete2);
            while($row2=mysqli_fetch_assoc($result2)){
                echo "<tr>";
                echo "<td>".$row2["productName"]."</td>";
                echo "<td>".($row2["productPrice"] * $row["productQtNeeded"])." $</td>";
                echo "<td>".(($row2["productPrice"] * $row["productQtNeeded"])*1500)." LL</td>";
                echo "</tr>";
                $somme+=$row2["productPrice"] * $row["productQtNeeded"];
            }
        }
        //recupere "shipping cost" de la ville de l'utilisateur
        $requete="select fees from location where city='".$_SESSION["city"]."'";
        $result=mysqli_query($con,$requete);
        $row=mysqli_fetch_assoc($result);
        echo "<tr class=\"shipping-tr\">";
        echo "<td><b><i>shipping Cost<i></b></td>";
        echo "<td class=\"shipping-cost1\">".$row["fees"]." $</td>";
        echo "<td class=\"shipping-cost2\">".($row["fees"] * 1500)." LL</td>";
        $somme+=$row["fees"];
    echo "</tr>";
    echo "<tr>";
    echo "<td><b>Total Price without discounts</b></td><td id=\"total\" class=\"total-price1\">".$somme." $</td>";
    echo "<td class=\"total-price2\">".($somme*1500)." LL</td>";
    echo "</tr>";
    echo "<td><b>Total Price with discounts</b></td><td id=\"totalDiscountD\" class=\"total-price1\">".($somme-$somme*($discount/100))." $</td>";
    echo "<td id=\"totalDiscountLL\">".(($somme-$somme*($discount/100))*1500)." LL</td>";
    echo "</tr>";
    mysqli_close($con);
    ?>
    </table>
</div>
</div>

<script>
    $(document).ready(function(){
        var city="";
        var totalPrice="";
        checkCart();
        $("#city").change(function(){
           city=$("#city").val();
           $.ajax({
           type:"POST",
           dataType:"JSON",
           url:"../ajax/update_order_somme/changeCityHandler.php",
           data:{city:city},
           success:function(response){
            var nouveauPrix=response[0].total;
            var nouveauShipping=response[0].fees;
            var discount=response[0].discount;
            var totalPrixAvecDiscountD=nouveauPrix- nouveauPrix*(discount/100);
            var totalPrixAvecDiscountLL=(nouveauPrix- nouveauPrix*(discount/100)) * 1500;
                        //changer
            $(".total-price1").empty();
            $(".total-price1").append(nouveauPrix+" $");
            $(".total-price2").empty();
            $(".total-price2").append((nouveauPrix*1500)+" LL");
            $(".shipping-cost1").empty();
            $(".shipping-cost1").append(nouveauShipping+" $");
            $(".shipping-cost2").empty();
            $(".shipping-cost2").append((nouveauShipping*1500)+" LL");
            $("#totalDiscountD").empty();
            $("#totalDiscountD").append(totalPrixAvecDiscountD +" $");
            $("#totalDiscountLL").empty();
            $("#totalDiscountLL").append(totalPrixAvecDiscountLL+ "LL");
        }
        });  
        })

         //effectuer order
         $("#order").click(function(){
                var city =$("#city").val();
                var email=$("#email").val();
                var adress=$("#adress").val();
                $.ajax({
                type:"POST",
                url:"../ajax/make_order/orderMaker.php",
                data:{city:city,email:email,adress:adress},
                success:function(response){
                    console.log(response);
                        if(response.length==0){
                            $(".order-container").empty();
                            $(".order-container").append("<h1>Order made successfully</h2>");
                        }
                        else{
                            $(".error").empty();
                            $(".error").append(response);
                        }
                }});
            }) 
            function checkCart(){
                $.ajax({
                    type:"POST",
                url:"../ajax/refresh/refreshCart.php",
                success:function(response){
                    if(response==="No products found in your cart"){
                        $(".order-container").empty();
                        $(".order-container").append("<h1>You can't make order because your cart is empty</h1>");

                    }
                }
                })
            }
    })
</script>
<?php
include "../footer/footer.php";
?>