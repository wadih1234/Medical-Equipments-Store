<?php
include "../../general_functions_classes/classes.php";
include "../../db_con/connection.php";
session_start();
$product="";
if(!isset($_SESSION["clientId"]) && empty($_SESSION["clientId"]) && !isset($_SESSION["companyId"]) && empty($_SESSION["companyId"])){
  echo "Please log in to purchase products";  
  exit();
}
if(isset($_POST["p_id"]) && !empty($_POST["p_id"])
    && isset($_POST["qt"]) && !empty($_POST["qt"])){
        $quantiteDemande=$_POST["qt"];
        if(!preg_match("/^[1-9]+$/",$quantiteDemande)) echo "Incorrect quantity";
        //si la quantite demandee est plus grande que celle dans le stock
        $requete="select productQuantity from products where productId=".$_POST["p_id"];
        $result=mysqli_query($con,$requete);
        $row=mysqli_fetch_assoc($result);
        if($row["productQuantity"]<$quantiteDemande){
            echo "the maximum quantity of this product is ".$row["productQuantity"];
            exit();
        }        
    $product=new Product();
    $product->fillProduct($con,$_POST["p_id"]);
    //si un client est logged in
    if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"]))
    $product->addProductToCart($con,$_SESSION["clientId"],$_POST["p_id"],$quantiteDemande);
    //si company est logged in
    else{
        $product->addProductToCart($con,$_SESSION["companyId"],$_POST["p_id"],$quantiteDemande);
    }
}
?>