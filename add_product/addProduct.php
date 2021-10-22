<?php
include "../header/header.php";
?>
<head>
    <link rel="stylesheet" href="addProductStyle.css">
</head>
<h1>Add Product Page</h1>
<div class="add-product-container">
    <h3>Please fill the form below.</h3>
    <?php 
if(isset($_GET["error"]) && !empty($_GET["error"])) echo "<div class=\"error\">". $_GET["error"] . "</div>";
if(isset($_GET["success"]) && !empty($_GET["success"])) echo "<div class=\"success\">". $_GET["success"] . "</div>";
?>
    <form method="POST" enctype="multipart/form-data" action="productAddHandler.php">
    <span class="spans">Product name</span>
    <span class="spans"><input type="text" name="pname" class="input"/></span>
    <span class="spans">Product Price</span>
    <span class="spans"><input type="text" name="pprice" class="input"/></span>
    <span class="spans">Product quantity</span>
    <span class="spans"><input type="number" name="pquantity" class="input"/></span>
    <span class="spans">Product category</span>
    <span class="spans">
        <select id="category" name="pcategory">
        <?php 
             include "../db_con/connection.php";
            $allCategories="select categoryName,categoryId from categories";
            $result=mysqli_query($con,$allCategories);
            echo "<option>-- Select category --</option>";
            while($row=mysqli_fetch_assoc($result)){
             echo "<option value=".$row["categoryId"].">".$row["categoryName"]."</option>";
                    }
            mysqli_close($con);
                ?>
        </select>
    </span>
    <span class="spans">Product sub category</span>
    <span class="spans">
        <select id="subcategory" name="psubcategory">
        <option>-- Select subcategory --</option>
        </select>
    </span>
    <span class="spans">Product image</span>
    <span class="spans"><input type="file" name="pimage" class="input"/></span>
    <span class="spans">Product Description <i></i></span>
    <span class="spans"><input type="text" name="pinfo" class="input"/></span>
    <span class="spans"><input type="submit" class="input" value="Add product"/></span>
    </form>
</div>
<script>
    $(document).ready(function(){
        $("#category").click(function(){
            var categoryid=$(this).val();
           $.ajax({
           type:"POST",
           url:"../ajax/load_subcategories/subcategorie.php",
           data:"catId="+categoryid,
           success:function(data){
               $("#subcategory").html(data);
           }
        })
        }); 
    });
</script>
<?php
include "../footer/footer.php";
?>