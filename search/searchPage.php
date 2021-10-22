<?php
include "../header/header.php";
include "../db_con/connection.php";
?>
<head>
    <link rel="stylesheet" href="searchPage.css"/>
</head>
<h1>Search Page</h1>
<div class="products">
<?php
if(isset($_POST["search"]) && !empty($_POST["search"])){
    $search=$_POST["search"];
     //si un user est logged In
     $user="";
     if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"])){
         $user=$_SESSION["clientId"];
     }
     if(isset($_SESSION["companyId"]) && !empty($_SESSION["companyId"])){
         $user=$_SESSION["companyId"];
     }
     //si un user est loggedIn
     //recuperer les produits qui ne trouvent pas dans sa cart
     if(!empty($user)){
         $requete="select productId,productName,productPrice,productimageSrc,productQuantity from products where productName LIKE '%$search%' and productName not in(select productName from cart where userId=$user)";
     }else{
    $requete="select productId,productName,productPrice,productimageSrc,productQuantity from products where productName LIKE '%$search%'";
     }
    $result=mysqli_query($con,$requete);
    $counter=1;
    if(mysqli_num_rows($result)==0){
        echo "<h3>No products found</h3>";
    }else{
    while($row=mysqli_fetch_assoc($result)){
        echo "<div class=\"product\" id=\"p$counter\">";
        echo "<div class=\"info\"></div>";
        echo "<img src=".$row["productimageSrc"].">";
        echo "<p class=\"p_name\">".$row["productName"]."</p>";
        echo "<div class=\"priceDiv\">";
        echo "<p class=\"p_price\">".$row["productPrice"]." $</p>";
        echo "<p class=\"p_price\">".($row["productPrice"] * 1500)." LL</p>";
        echo "</div>";
        echo "<p><input type=\"number\" min=1 class=\"p_n\" value=\"1\"></p>";
        echo "<div class=\"btn\">";
        echo "<button class=\"p_preview\" p_id=".$row["productId"].">Preview</button>";
        echo "<button class=\"p_cart\" p_id=".$row["productId"].">Add to cart</button>";
        echo "</div>";
        echo "</div>";
        $counter++;
    }
}
}
?>
<div class="arrow">UP</div>
</div>
<script>
    $(document).ready(function(){
        //si on veut ajouter un produit a la cart
        $(".products").on('click','.p_cart',function(){
            //prendre l'id du produit (ajoute dans un attr de ".p_cart")
            var productId=$(this).attr("p_id");
            //prendre l'id du parent example p1,p2,p3...
            var parent=$(this).parent().parent().attr("id");
            //prendre la quantite desire
            var qt=$("#"+parent+" .p_n").val();
            $.ajax({
           type:"POST",
           url:"../ajax/operations/addToCart.php",
           data:{p_id:productId,qt:qt},
           success:function(response){
                    //ecrire dans l'info si user n'est pas logged in
                    if(response.length>0){
                    $("#"+parent+" .info").empty();
                    $("#"+parent+" .info").append(response);
                    }
                    else{
                    //mettre le bouton disabled
                    $("#"+parent+" .btn .p_cart").attr("disabled",true);
                    $("#"+parent+" .btn .p_cart").empty();
                    $("#"+parent+" .btn .p_cart").append("added");
                    $("#"+parent+" .btn .p_cart").attr("class","added");
                    }
               }
           })
        })

        //si on veut voir un produit
        $(".products").on('click','.p_preview',function(){
            //prendre l'id du produit (ajoute dans un attr de ".p_preview")
            var productId=$(this).attr("p_id");
            console.log(productId);
            $.ajax({
           type:"POST",
           dataType:"JSON",
           url:"../products/productPreview.php",
           data:{productId:productId},
           success:function(response){
               var product="<div class='product-preview'><div class='product' id='prod'><div class=\"info\"></div><p><img src='"+response[0].productImage+"'></p><p class='p_name'>"+response[0].productName+"</p><div class='priceDiv'><p class='p_price'>Product Price : "+response[0].productPrice+" $</p></div><p><input type='number' min='1' class='p_n' value='1'></p><p>Product Description : 1</p><p>Product Quantity in stock : "+response[0].productQuantity+"</p><div class='btn'><button class='p_cart' p_id='"+response[0].productId+"'>Add to cart</button></div></div></div>";
            $(".products").empty();  
            $(".products").append(product);
               }
           })
        })

    })

    let btn=document.querySelector(".arrow");
     window.onscroll=function(){
        if(window.scrollY >= 600){
            btn.style.display="block";
        }
        else{
            btn.style.display="none";
        }
     }
     btn.onclick=function(){
         window.scrollTo({
             left:0,top:0,behavior:"smooth"
         })
     }

</script>
<?php
include "../footer/footer.php";
?>