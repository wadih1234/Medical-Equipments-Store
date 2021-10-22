<?php
include "../../db_con/connection.php";
session_start();
$user="";
$checker=true;
$error="";
$somme=0;
$discount="";
if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"])){
    $user=$_SESSION["clientId"];
    //trouver discount
    $requete="select discount from clients where clientId=".$user;
    $result=mysqli_query($con,$requete);
    $row=mysqli_fetch_assoc($result);
    $discount=$row["discount"];
}

if(isset($_SESSION["companyId"]) && !empty($_SESSION["companyId"])){
    $user=$_SESSION["companyId"];
    //trouver discount
    $requete="select discount from company where companyId=".$user;
    $result=mysqli_query($con,$requete);
    $row=mysqli_fetch_assoc($result);
    $discount=$row["discount"];
}


if(isset($_POST["email"]) &&!empty($_POST["email"])
&& isset($_POST["city"]) && !empty($_POST["city"]) && isset($_POST["adress"]) && !empty($_POST["adress"])){
    //variables
    $email=$_POST["email"];
    $city=$_POST["city"];
    $adress=$_POST["adress"];
    //validation
    if(!preg_match("/^\w+@\w+[.]\w+$/",$email)){
        $error.="email contains errors<br>";
        $checker=false;
        }
    if(!preg_match("/^[a-zA-Z]+$/",$city)){
        $error.="city can contains only letters";
        $checker=false;
    }   
    if($checker){
        $requete="select productId,productQtNeeded from cart where userId=$user";
        $result=mysqli_query($con,$requete);
        while($row=mysqli_fetch_assoc($result)){
            //recuperer pour chaque produit de la cart son prix
            $requete2="select productPrice from products where productId=".$row["productId"];
            $result2=mysqli_query($con,$requete2);
            while($row2=mysqli_fetch_assoc($result2)){
                $somme+=$row2["productPrice"] * $row["productQtNeeded"];
            }   
    }
    $requete="select fees from location where city='".$city."'";
        $result=mysqli_query($con,$requete);
        $row=mysqli_fetch_assoc($result);
        $somme+=$row["fees"];
        //ajouter discount sur somme
        $somme=$somme-$somme*($discount/100);
        //inserer dans l'order si tout est valider
        if(empty($error)){
        $requete="Insert into orders (userId,Date,price,adress,status,email) values($user,NOW(),$somme,'$adress','N/U','$email')";
        mysqli_query($con,$requete);
        //diminuer la quantite de chaque produit
        $requete="select productId,productQtNeeded from cart where userId=".$user;
        $result=mysqli_query($con,$requete);
        while($row=mysqli_fetch_assoc($result)){
           $requete2="Update products set productQuantity=productQuantity -".$row["productQtNeeded"]." where productId=".$row["productId"];
           mysqli_query($con,$requete2);
        }
       //delete user cart car elle l'order est fait
       $requete="Delete from cart where userId=".$user;
       mysqli_query($con,$requete);
    }
}
}
else{
    $error="All fields are required";
}
if(!empty($error)) echo $error;

?>