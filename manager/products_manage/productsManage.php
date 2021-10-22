<?php 
include "../../db_con/connection.php";
session_start();
if(!isset($_SESSION["managerUser"]) && empty($_SESSION["managerUser"])){
    echo "<h1>You can't view this page</h1>.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="productsManageStyle.css"/>
    <title>Products Manage</title>
</head>
<body>
    <div class="products-manage-container">
        <div class="h-btn">
        <h1>Products Page</h1>
        <div class="btn">
        <a href="../../manager/managers_home/managerHome.php"><input type="button" class="btn-home" value="manager Home Page"/></a>
        <form method="POST" action="../logoutManager.php">
        <input type="submit" value="Log out"/>
        </form>
        </div>
        </div>
        <div class="category-details">
        </div>
    <hr></hr>
    <div class="category-add">
        <h3>Add a new Category</h3>
        <p><i>This section is for adding a new category.</i></p>
        <form method="POST" action="productsManageHandler.php">
            <p>
                <?php
                if(isset($_GET["success"]) && !empty($_GET["success"])) echo $_GET["success"];
            ?>
                </p>
        <table>
            <tr>
                <td>Category name</td>
                <td><input type="text" id="name" name="catName"></td>
            </tr>

            <td><input type="submit" id="add" value="Add"/></td>
        </tr>
        </table>
    </form>
    <hr></hr>
    <div>
        <h3>Sub Categories</h3>
    <p><i>This section is for viewing/deleting a subCategory.</i></p>
        <div class="sub-category-details">
        </div>
    </div>
    <hr></hr>
    <div class="subcategory-add">
        <h3>Add new subCategory</h3>
        <p><i>This section is for adding a new subCategory.</i></p>
        <p>
                <?php
                if(isset($_GET["success"]) && !empty($_GET["success"])) echo $_GET["success"];
            ?>
                </p>
        <form method="POST" action="productsManageHandler.php">
        <table>
            <tr>
                <td>subCategory name</td>
                <td><input type="text" id="name" name="subcname"></td>
            </tr>
            <tr>
            <td>add this subCategory to </td>
            <td><select name="toCategory"><?php 
            $allCategories="select categoryName,categoryId from categories";
            $result=mysqli_query($con,$allCategories);
            echo "<option>-- Select category --</option>";
            while($row=mysqli_fetch_assoc($result)){
             echo "<option value=".$row["categoryId"].">".$row["categoryName"]."</option>";
                    }
                ?></select></td>
            </tr>
            <td><input type="submit" id="add" value="Add"/></td>
        </tr>
        </table>
        </form>
        <hr></hr>
        </div>
        <div class="products-view">
        <h3>Products</h3>
        <p><i>This section is for viewing/updating/deleting an existing product</i></p>
        <div class="products-details">
        </div>
    </div>
    <div class="products-update">
        <hr></hr>
        <h3>Update an existing Product</h3>
        <table>
        <form method="POST" enctype="multipart/form-data" action="productUpdateHandler.php">
        <tr>
        <td>Product ID</td>
        <td><input type="text" name="productId" id="pid" class="input" readonly/></td>
        </tr>
        <tr>
        <td>Product name</td>
        <td><input type="text" id="pnameU" name="productName" class="input"/></td>
        </tr>
        <td>Product Price</td>
        <td><input type="text" id="ppriceU" name="productPrice" class="input"/></td>
        <tr>
        <td>Product quantity</td>
        <td><input type="number"id="pquantityU" name="productQuantity" class="input"/></td>
        <tr>
        <td><input type="submit" class="input" value="Update"/></td>
        </tr>
        </form>
        </table>
        </div>
    <hr></hr>
        <div class="products-add">
        <h3>Add a new Product</h3>
        <p><i>This section is for adding a new product</i></p>
        <table>
        <form method="POST" enctype="multipart/form-data" action="productAddUpdate.php">
        <tr>
        <td>Product name</td>
        <td><input type="text" name="pname" class="input"/></td>
        </tr>
        <td>Product Price</td>
        <td><input type="text" name="pprice" class="input"/></td>
        <tr>
        <td>Product quantity</td>
        <td><input type="number" name="pquantity" class="input"/></td>
        <tr>
        <td>Product category</td>
        <td>
        <select id="category2" name="pcategory">
        <?php 
            $allCategories="select categoryName,categoryId from categories";
            $result=mysqli_query($con,$allCategories);
            echo "<option>-- Select category --</option>";
            while($row=mysqli_fetch_assoc($result)){
             echo "<option value=".$row["categoryId"].">".$row["categoryName"]."</option>";        
            }
                ?>
        </select>
        </td>
    </tr>
    <td>Product sub category</td>
    <td>
        <select id="subcategory2" name="psubcategory">
        </select>
    </td>
    </tr>
    <td>Product image</td>
    <td><input type="file" name="pimage" class="input"/></td>
    </tr>
    <td>Product Description</td>
    <td><input type="text" name="pinfo" class="input"/></td>
    </tr>
    </table>
    <td><input type="submit" class="input" value="Add"/></td>
    </form>
        </table>
        </div>
</div>
</div>

</body>
<script>
$(document).ready(function(){
        refreshCategories();
        refreshSubCategories();
        refreshProducts();
        $(".products-update").hide();
    //load subcategories
    $("#category").change(function() {
        $("#category").click(function(){
            var categoryid=$(this).val();
           $.ajax({
           type:"POST",
           url:"../../ajax/load_subcategories/subcategorie.php",
           data:"catId="+categoryid,
           success:function(data){
               $("#subcategory").html(data);
           }
        })
        });
    })
     //load subcategories
     $("#category2").change(function() {
        $("#category2").click(function(){
            var categoryid=$(this).val();
           $.ajax({
           type:"POST",
           url:"../../ajax/load_subcategories/subcategorie.php",
           data:"catId="+categoryid,
           success:function(data){
               $("#subcategory2").html(data);
           }
        })
        });
    })

        // //si on veut changer les infos d'une company existante
         $(".products-details").on('click','#update',function(){
           var tableName="products";
            var parent=$(this).parent().parent().attr("id");
           var productId=$("#"+parent+" #product_id").val();
            $.ajax({
                type:"POST",
                dataType:"JSON",
                url:"../../ajax/operations/showUpdate.php",
           data:{productId:productId,table:tableName},
            success:function(response){
                    $(".products-update").show();
                    $("#pid").attr("value",response[0].productId);
                    $("#pnameU").attr("value",response[0].productName);
                    $("#ppriceU").attr("value",response[0].productPrice);
                   $("#pquantityU").attr("value",response[0].productQuantity);
                }
             })
         });

        //si on veut supprimer une categorie
       $(".category-details").on('click','#delete',function(){
           //parent
           var parent=$(this).parent().parent().attr("id");
           var categoryId=$("#"+parent+" #categorie_id").val();
           var tableName="category";
           //envoye categoryId a deleting
           $.ajax({
           type:"POST",
           url:"../../ajax/operations/deleting.php",
           data:{categoryId:categoryId,table:tableName},
           success:function(response){
            refreshCategories();
            refreshSubCategories();
               }
           })
       });

       //si on veut supprimer une categorie
       $(".sub-category-details").on('click','#delete',function(){
           //parent
           var parent=$(this).parent().parent().attr("id");
           var subcategoryId=$("#"+parent+" #subcategorie_id").val();
           var tableName="subcategory";
           //envoye categoryId a deleting
           $.ajax({
           type:"POST",
           url:"../../ajax/operations/deleting.php",
           data:{subcategoryId:subcategoryId,table:tableName},
           success:function(response){
            refreshSubCategories();
               }
           })
       });

       //si on veut supprimer un produit
       $(".products-details").on('click','#delete',function(){
           //parent
           var parent=$(this).parent().parent().attr("id");
           var productId=$("#"+parent+" #product_id").val();
           var tableName="products";
           //envoye categoryId a deleting
           $.ajax({
           type:"POST",
           url:"../../ajax/operations/deleting.php",
           data:{productId:productId,table:tableName},
           success:function(response){
            refreshProducts();
               }
           })
       });

    //mettre a jour les categories
    function refreshCategories(){
        $.ajax({
           type:"POST",
           url:"../../ajax/refresh/refreshCategory.php",
           success:function(response){
            $(".category-details").empty();
               $(".category-details").append("<h3>Categories</h3>");
               $(".category-details").append(response);
               }
           })
       }

    //mettre a jour les subcategories
    function refreshSubCategories(){
        $.ajax({
           type:"POST",
           url:"../../ajax/refresh/refreshSubCategories.php",
           success:function(response){
            $(".sub-category-details").empty();
               $(".sub-category-details").append("<h3>Sub-Categories</h3>");
               $(".sub-category-details").append(response);
               }
           })
       }  
     //mettre a jour les produits
     function refreshProducts(){
        $.ajax({
           type:"POST",
           url:"../../ajax/refresh/refreshProducts.php",
           success:function(response){
            $(".products-details").empty();
               $(".products-details").append("<h3>Products</h3>");
               $(".products-details").append(response);
               }
           })
       }       

})
</script>
</html>