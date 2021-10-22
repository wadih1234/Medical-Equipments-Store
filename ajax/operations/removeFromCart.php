<?php
session_start();
include "../../db_con/connection.php";
if(!isset($_SESSION["clientId"]) && empty($_SESSION["clientId"]) && !isset($_SESSION["companyId"]) && empty($_SESSION["companyId"])){
    echo "Error";
}
else{
    if(isset($_POST["p_id"]) && !empty(isset($_POST["p_id"]))){
        $productId=$_POST["p_id"];
        //verifier quel utilisateur est logged in
        if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"])){
            $user=$_SESSION["clientId"];
        }
        else{
            $user=$_SESSION["companyId"];
        }
        //requete de suppression du produit
        $requete="Delete from cart where userId=$user and productId=$productId";
        mysqli_query($con,$requete);
        mysqli_close($con);
    }
}
?>