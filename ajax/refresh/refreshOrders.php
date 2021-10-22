<?php
include "../../db_con/connection.php";
$resultat="";
    $requete="select orderId,userId,date,price,status from orders";
    $result=mysqli_query($con,$requete);
    $resultat="<table class=\"orders-table\">";
    $resultat.="<tr>";
    $resultat.="<th>order ID</th>";    
    $resultat.="<th>user ID</th>";    
    $resultat.="<th>Date</th>";    
    $resultat.="<th>Price</th>";    
    $resultat.="<th>Status</th>";    
    $resultat.="<th>Operation</th>";
    $counter=1;    
    while($row=mysqli_fetch_assoc($result)){
        $resultat.="<tr id=row$counter>";
        $resultat.="<input type=\"hidden\" id=\"o_id\" value='".$row["orderId"]."'/>";
        $resultat.="<td>".$row["orderId"]."</td>";
        $resultat.="<td>".$row["userId"]."</td>";
        $resultat.="<td>".$row["date"]."</td>";
        $resultat.="<td>".$row["price"]."</td>";
        $resultat.="<td>".$row["status"]."</td>";
        $resultat.="<td><input type=\"button\" id=\"delete\" value=\"Delete\"/>";
        $resultat.="</tr>";
        $counter++;
    }
    $resultat.="</table>";
    mysqli_close($con);
    echo $resultat;
?>