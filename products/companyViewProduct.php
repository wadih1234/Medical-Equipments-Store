<?php
include "../header/header.php";
include "../db_con/connection.php";
if(!isset($_SESSION["companyId"]) && empty($_SESSION["companyId"])){
    exit();
}
?>
<head>
    <link rel="stylesheet" href="companyViewProduct.css"/>
</head>
<h1>Company product Page</h1>
<div class="products">
<?php
if(isset($_SESSION["companyId"]) && !empty($_SESSION["companyId"])){
    $companyId=$_SESSION["companyId"];
    $requete="select productId,productName,productPrice,productimageSrc,productQuantity from products where companyId=$companyId";
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
        echo "</div>";
        echo "</div>";
        $counter++;
    }
}
}
?>
</div>
<script>
    $(document).ready(function(){
        //si on veut voir un produit
        $(".products").on('click','.p_preview',function(){
            //prendre l'id du produit (ajoute dans un attr de ".p_preview")
            var productId=$(this).attr("p_id");
            $.ajax({
           type:"POST",
           dataType:"JSON",
           url:"../products/productPreview.php",
           data:{productId:productId},
           success:function(response){
               if(response[0].productDescription.length==0){
                var product="<div class='product-preview'><div class='product' id='prod'><div class=\"info\"></div><p><img src='"+response[0].productImage+"'></p><p class='p_name'>"+response[0].productName+"</p><div class='priceDiv'><p class='p_price'>Product Price : "+response[0].productPrice+" $</p></div><p><input type='number' min='1' class='p_n' value='1'></p><p>Product Quantity in stock : "+response[0].productQuantity+"</p><div class='btn'><button class='p_cart' p_id='"+response[0].productId+"'>Add to cart</button></div></div></div>";
            $(".products").empty();  
            $(".products").append(product);
               }
                   
               else{
                var product="<div class='product-preview'><div class='product' id='prod'><div class=\"info\"></div><p><img src='"+response[0].productImage+"'></p><p class='p_name'>"+response[0].productName+"</p><div class='priceDiv'><p class='p_price'>Product Price : "+response[0].productPrice+" $</p></div><p><input type='number' min='1' class='p_n' value='1'></p><p>Product Description : "+response[0].productDescription +"</p><p>Product Quantity in stock : "+response[0].productQuantity+"</p><div class='btn'><button class='p_cart' p_id='"+response[0].productId+"'>Add to cart</button></div></div></div>";
            $(".products").empty();  
            $(".products").append(product);
               }
               }
           })
        })

    })
</script>
<?php
include "../footer/footer.php";
?>