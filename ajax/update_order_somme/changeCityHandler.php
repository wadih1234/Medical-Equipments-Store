<?php
include "../../db_con/connection.php";
session_start();
$result_array=[];
$user="";
$somme=0;
$discount="";
if(!isset($_SESSION["companyId"]) && empty($_SESSION["companyId"])
 && !isset($_SESSION["clientId"]) && empty($_SESSION["clientId"])){
    exit();
}
if(isset($_POST["city"]) && !empty($_POST["city"])){
    if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"])){
        $user=$_SESSION["clientId"];
        //trouver discount
    $requete="select discount from clients where clientId=".$user;
    $result=mysqli_query($con,$requete);
    $row=mysqli_fetch_assoc($result);
    $discount=$row["discount"];
    }
    else{
        $user=$_SESSION["companyId"];
        //trouver discount
    $requete="select discount from company where companyId=".$user;
    $result=mysqli_query($con,$requete);
    $row=mysqli_fetch_assoc($result);
    $discount=$row["discount"];
    }
    //recupere le nouvau "shipping" prix de la nouvelle ville
    $requete="select fees from location where city='".$_POST["city"]."'";
    $result=mysqli_query($con,$requete);
    $row=mysqli_fetch_assoc($result);
    $fees=$row["fees"];
    //recuperer la somme des produit dans la cart de l'utilisateur
    $requete = "select productId,productQtNeeded from cart where userId=$user";
    $result = mysqli_query($con,$requete);
    while($row=mysqli_fetch_assoc($result)){
        //recuperer pour chaque produit de la cart son prix
        $requete2="select productName,productPrice from products where productId=".$row["productId"];
        $result2=mysqli_query($con,$requete2);
        while($row2=mysqli_fetch_assoc($result2)){
            $somme+=$row2["productPrice"] * $row["productQtNeeded"];
}

    }
    $somme+=$fees;
    $result_array[]=array(
        "total" => $somme,
        "fees" => $fees,
        "discount" =>$discount
    );
    mysqli_close($con);
    echo json_encode($result_array);
}
?>