<?php
include "../../db_con/connection.php";
$checker=true;
if(isset($_POST["productId"]) && !empty($_POST["productId"])
&& isset($_POST["productName"]) && !empty($_POST["productName"]) 
&& isset($_POST["productQuantity"]) && !empty($_POST["productQuantity"])
&& isset($_POST["productPrice"]) && !empty($_POST["productPrice"])){
   $productName=$_POST["productName"];
   $productPrice=$_POST["productPrice"];
   $productQuantity=$_POST["productQuantity"];
   if(!preg_match("/^\w+(\s+\w+)*$/",$productName)){
    $checker=false;
}
if(!preg_match("/^[0-9]+$/",$productPrice)){
    $checker=false;
}
if(!preg_match("/^[0-9]+$/",$productQuantity)){
    $checker=false;
}
if($checker){
    $requete="Update products set productName='$productName',productPrice='$productPrice',productQuantity='$productQuantity' where productId=".$_POST["productId"];
    mysqli_query($con,$requete);
    mysqli_close($con);
}
header("Location:productsManage.php");
}
?>