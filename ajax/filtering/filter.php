<?php
include "../../db_con/connection.php";
$returnedArray=[];
session_start();
if(isset($_POST["catId"]) && !empty($_POST["catId"])){
    $quantity="";
    $price="";
    $user="";
    $catId=$_POST["catId"];
    if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"])){
        $user=$_SESSION["clientId"];
    }
    if(isset($_SESSION["companyId"]) && !empty($_SESSION["companyId"])){
        $user=$_SESSION["companyId"];
    }
    //si un user est loggedIn
    //recuperer les produits qui ne trouvent pas dans sa cart
    if(!empty($user)){
        $requete="select productId,productName,productPrice,productimageSrc,productQuantity from products where productCategory=$catId  and productId not in(select productId from cart where userId=$user)";
    }
    else{
    $requete="Select productId,productName,productPrice,productimageSrc from products where
    productCategory=$catId";
    }
    //si on a clique sur un "subcategory" modifier l a requete en ajoutant l'id de "subcategory"
    if(isset($_POST["subcatId"]) && !empty($_POST["subcatId"])){
        $subcatId=$_POST["subcatId"];
        $requete.=" and productsubCategory=$subcatId";
    }
    //si la quantite est donnee
    if(isset($_POST["quantity"]) && !empty($_POST["quantity"])){
        $quantity=$_POST["quantity"];
        if(!preg_match("/^[0-9]+$/",$quantity)){
            echo "Quantity must contains only numbers";
            exit();
        }
        $requete.=" and productQuantity = $quantity";
    }
    //si un des prix est selectionne
    if(isset($_POST["selectedPrice"]) && !empty($_POST["selectedPrice"])){
        $price=$_POST["selectedPrice"];
        switch($price){
            case "lowtohigh": $requete.=" order by productPrice ASC"; break;
            case "hightolow": $requete.=" order by productPrice DESC";break;
            case "f10to50": $requete.=" and productPrice BETWEEN 10 and 50";break;
            case "f100to500": $requete.=" and productPrice BETWEEN 100 and 500";break;
            case "f500": $requete.=" and productPrice >= 500";break;
        }
    }
    //la requete est prete a etre executee
    $result=mysqli_query($con,$requete);
    if(mysqli_num_rows($result)==0){
        $returnedArray[]="No products found";
    }
    while($row=mysqli_fetch_assoc($result)){
        $returnedArray[]=array(
            "productId" => $row["productId"],
            "productName" => $row["productName"],
            "productPrice" => $row["productPrice"],
            "productImage" => $row["productimageSrc"]
        );
    }
}
//retourne un json array des produits
echo json_encode($returnedArray);
?>