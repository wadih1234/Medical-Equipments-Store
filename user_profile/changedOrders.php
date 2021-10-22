<?php
include "../db_con/connection.php";
session_start();
if(!isset($_SESSION["clientId"]) && empty($_SESSION["clientId"])
 && !isset($_SESSION["companyId"]) && empty($_SESSION["companyId"])){
     exit();
 }
if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"])){
    $user=$_SESSION["clientId"];
}
if(isset($_SESSION["companyId"]) && !empty($_SESSION["companyId"])){
    $user=$_SESSION["companyId"];
}
$resultat="";
    $requete="select orderId,userId,date,price,status from orders";
    $result=mysqli_query($con,$requete);
    $resultat.="<h3>Orders history</h3>";    
    $resultat.="<div class=\"content\">";
    $resultat.="<table>";
    $resultat.="<th>Date</th>";
    $resultat.="<th>Price</th>";
    $resultat.="<th>Adress</th>";
    $resultat.="<th>Status</th>";
    $resultat.="<th>Operation</th>";
            $requete="Select orderId,Date,price,adress,status from orders where userId=$user";
                $result=mysqli_query($con,$requete);
                $counter=1;
                while($row=mysqli_fetch_assoc($result)){
                    $resultat.="<tr id='row$counter'>";
                    $resultat.="<input type=hidden id=\"o_id\"  value='".$row["orderId"]."' >";
                    $resultat.="<td>".$row["Date"]."</td>";
                    $resultat.="<td>".$row["price"]." $ </td>";
                    $resultat.="<td>".$row["adress"]."</td>";
                    $resultat.="<td>".$row["status"]."</td>";
                    $resultat.="<td><input type=\"button\" id=\"update\" value=\"update\"/></td>";
                    $resultat.="</tr>";
                    $counter++;
                }
        $resultat.="</table>";
    $resultat.="</div>";
    mysqli_close($con);
    echo $resultat;
?>