<?php
include "../header/header.php";
include "../db_con/connection.php";
$categoryId="";
//verifier que le query parameter est valide et existe dans notre db
if(isset($_GET["i"]) && !empty($_GET["i"])){
    //verifier que le categoryId donnee est un entier
    $categoryId=$_GET["i"];
    if(!preg_match("/^[0-9]+$/",$categoryId)){
        echo "<h1 class=\"main-error\" style=\"color:red\">Something went wrong.</h1>";
        exit();
    }
    }
    else{
        echo "<h1 class=\"main-error\">Something went wrong.</h1>";
        exit();
    }
?>
<head>
    <link rel="stylesheet" href="viewProductsStyle.css">
</head>
<?php
//chercher le nom de la category
$chercherNomCategory="select categoryName,categoryId from categories where categoryId=".$categoryId;
$result=mysqli_query($con,$chercherNomCategory);
$row=mysqli_fetch_assoc($result);
echo "<h1>".$row["categoryName"]."
<input type=\"hidden\" value=".$row["categoryId"]."></h1>";
echo "<h3 class=\"infoMsg\"><i>Showing ".$row["categoryName"]." category products</i></h3>";
?>
<div class="products_container">
    <div class="left-container">
        <div class="subcategory">
            <h3>Subcategories</h3>
            <?php
            //prendre CategoryId et chercher les sub categories
            $chercherSubCategories="select subCname,subcategoryId from subcategories where categoryId=".$categoryId;
            $subCategoriesresult=mysqli_query($con,$chercherSubCategories);
            echo "<ul class=\"sub\">";
            $counter=1;
        while($row=mysqli_fetch_assoc($subCategoriesresult)){
            echo "<li id=\"sub$counter\">".$row["subCname"]."
            <input type=\"hidden\" value=".$row["subcategoryId"]."></li>";
            $counter++;
            }
            echo "</ul>";
?>
        </div>
            <div class="filter-container">
                <p>Filter</p>
                
                <p>Price</p>
                <div>
                    <input type="radio" name="price" value="lowtohigh"/> From low to high
                </div>
                <div>
                    <input type="radio" name="price" value="hightolow"/> From high to low
                </div>
                <div>
                   <input type="radio" name="price" value="f10to50"/> From 10$ to 50$
                </div>
                <div>
                    <input type="radio" name="price" value="f100to500"/> From 100$ to 500$
                </div>
                <div>
                    <input type="radio" name="price" value="f500"/> >=500$
                </div>
                <p>Quantity in stock</p>
                <div>
                    <input type="text" id="qt" name="quantity"/>
                </div>
                <input type="button" class="filter" value="Filter"/>
            </div>
    </div>
    <div class="products">
        <?php
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
            $products="select productId,productName,productPrice,productimageSrc,productQuantity from products where productCategory=$categoryId and productQuantity > 0 and productId not in(select productId from cart where userId=$user)";
        }
        //sinon
        else{
            $products="select productId,productName,productPrice,productimageSrc,productQuantity from products where productCategory=".$categoryId." and productQuantity >0" ;
        }
            $result= mysqli_query($con,$products);
           $counter=1;
        while($row=mysqli_fetch_assoc($result))
        {
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
        ?>
        </div>
        <div class="arrow"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
</svg></div>
</div>

<script>
     $(document).ready(function(){
         //si on appuie sur une subcategory
         var subcategoryId="";
         var categoryId="";
         $(".products_container").on('click','.sub li',function(){
            //prendre l'id
            var id=$(this).attr("id");
            //prendre la valeur
            subcategoryId=$("#"+id+">input").val();
            //prendre category id
            categoryId=$("h1>input").val();
            $.ajax({
           type:"POST",
           dataType:"JSON",
           url:"../ajax/change-subcategory/productsHandler.php",
           data:{catId:categoryId,subcatId:subcategoryId},
           success:function(response){
            var productCounter=1;
               var resultat="";
               for(var i=0;i<response.length-1;i++){
                    var productId=response[i].productId;
                    var productName=response[i].productName;
                    var productPrice=response[i].productPrice;
                    var productImage=response[i].productImage;
                    var divProduct="<div class='product' id='p"+productCounter+"'><div class=\"info\"></div><p><img src='"+productImage+"'></p><p class='p_name'>"+productName+"</p><div class='priceDiv'><p class='p_price'>"+productPrice+" $</p><p>"+(productPrice*1500)+" LL</p></div><p><input type='number' min='1' class='p_n' value='1'></p><div class='btn'><button class='p_preview' p_id='"+productId+"' >Preview</button><button class='p_cart' p_id='"+productId+"'>Add to cart</button></div></div>";
                    resultat+=divProduct;
                    productCounter++;
               }
               $(".infoMsg").empty();
               $(".infoMsg").append("Showing "+response[i]+" products");
               $(".products").empty();
               $(".products").append(resultat);
           }
        });
        })
        //si le filter est appuye
            //si un checkbox de filter est selectionne
            $(".products_container").on('click','.filter',function(){
                //prendre category id
            var categoryId=$("h1>input").val();
                var selectedVal = "";
                var quantity="";
            var selected = $(".filter-container input[name='price']:checked");
            if (selected.length > 0) {
                selectedVal=selected.val();
                }
            if($("#qt").length>0){
                quantity=$("#qt").val();
            }

            $.ajax({
           type:"POST",
           url:"../ajax/filtering/filter.php",
           dataType:"JSON",
           data:{catId:categoryId,subcatId:subcategoryId,quantity:quantity,selectedPrice:selectedVal},
           success:function(response){
               if(response[0]==="No products found"){
                $(".products").empty();
               $(".products").append("<h3>"+response[0]+"</h3>");
               }
               else{
            var productCounter=1;
               var resultat="";
               for(var i=0;i<response.length;i++){
                    var productId=response[i].productId;
                    var productName=response[i].productName;
                    var productPrice=response[i].productPrice;
                    var productImage=response[i].productImage;
                    var divProduct="<div class='product' id='p"+productCounter+"'><div class=\"info\"></div><p><img src='"+productImage+"'></p><p class='p_name'>"+productName+"</p><div class='priceDiv'><p class='p_price'>"+productPrice+" $</p><p>"+(productPrice*1500)+" LL</p></div><p><input type='number' min='1' class='p_n' value='1'></p><div class='btn'><button class='p_preview' p_id='"+productId+"' >Preview</button><button class='p_cart' p_id='"+productId+"'>Add to cart</button></div></div>";
                    resultat+=divProduct;
                    productCounter++;
               }
               $(".products").empty();
               $(".products").append(resultat);
               }
           }
           })
        });

        //si on veut voir un produit
        $(".products_container").on('click','.p_preview',function(){
            //prendre ce qui trouve dans le grand container
           avantPage=$(".products_container").html();
            //prendre l'id du produit (ajoute dans un attr de ".p_preview")
            var productId=$(this).attr("p_id");
            $.ajax({
           type:"POST",
           dataType:"JSON",
           url:"productPreview.php",
           data:{productId:productId},
           success:function(response){
            if(response[0].productDescription.length==0){

                var product=
                "<div class='back'>Back</div>"
                +"<div class='product-preview'><div class='product' id='prod'><div class=\"info\"></div><p><img src='"+response[0].productImage+"'></p><p class='p_name'>"+response[0].productName+"</p><div class='priceDiv'><p class='p_price'>Product Price : "+response[0].productPrice+" $</p></div><p><input type='number' min='1' class='p_n' value='1'></p><p>Product Quantity in stock : "+response[0].productQuantity+"</p><div class='btn'><button class='p_cart' p_id='"+response[0].productId+"'>Add to cart</button></div></div></div>";
               }
                   
               else{
                var product="<div class='product-preview'><div class='product' id='prod'><div class=\"info\"></div><p><img src='"+response[0].productImage+"'></p><p class='p_name'>"+response[0].productName+"</p><div class='priceDiv'><p class='p_price'>Product Price : "+response[0].productPrice+" $</p></div><p><input type='number' min='1' class='p_n' value='1'></p><p>Product Description :</p><p> "+response[0].productDescription +"</p><p>Product Quantity in stock : "+response[0].productQuantity+"</p><div class='btn'><button class='p_cart' p_id='"+response[0].productId+"'>Add to cart</button></div></div></div>";
               }
            $(".products").empty();  
            $(".left-container").empty();
            $(".products").append(product);
               }
           })
        })

        //si on veut ajouter un produit a la cart
        $(".products_container").on('click','.p_cart',function(){
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
    });

    $(".products_container").on('click','.back',function(){
            $(".products_container").empty();
            $(".products_container").append(avantPage);
        });



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