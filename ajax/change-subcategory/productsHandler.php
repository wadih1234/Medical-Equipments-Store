<?php
include "../../db_con/connection.php";
session_start();
$returnedArray=[];
if(isset($_POST["catId"]) && !empty($_POST["catId"]) && isset($_POST["subcatId"]) && !empty($_POST["subcatId"])){
    $catId=$_POST["catId"];
    $subcatId=$_POST["subcatId"];
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
        $requete="select productId,productName,productPrice,productimageSrc,productQuantity from products where productCategory=$catId and productsubCategory=$subcatId and productId not in(select productId from cart where userId=$user)";
    }
    else{
    $requete="Select productId,productName,productPrice,productimageSrc from products where
    productCategory=$catId and productsubCategory=$subcatId";
    }
    $result=mysqli_query($con,$requete);
    while($row=mysqli_fetch_assoc($result)){
        $returnedArray[]=array(
            "productId" => $row["productId"],
            "productName" => $row["productName"],
            "productPrice" => $row["productPrice"],
            "productImage" => $row["productimageSrc"]
        );
    }
    //get the subcategoryName to add in infoMsg
    $requete="select subCname from subcategories where subcategoryId=$subcatId";
    $result=mysqli_query($con,$requete);
    $row=mysqli_fetch_assoc($result);
    $returnedArray[]=$row["subCname"];
    mysqli_close($con);
    //encode sous forme JSON
    echo json_encode($returnedArray);
}
?>