<?php
include "../../db_con/connection.php";
$resultatRetourne="";
    $requete="select productId,productPrice,productQuantity from products";
    $result=mysqli_query($con,$requete);
    
        $resultatRetourne.="<table class=\"products-table\">";
        $resultatRetourne.="<tr>";
        $resultatRetourne.="<th>Product ID</th>";
        $resultatRetourne.="<th>Product Price</th>";
        $resultatRetourne.="<th>Product Quantity</th>";
        $resultatRetourne.="<th>Operation</th>";
        $resultatRetourne.="</tr>";

    $counter=1;
    while($row=mysqli_fetch_assoc($result)){
        $resultatRetourne.="<tr id=\"row$counter\">";
        $resultatRetourne.="<input type=\"hidden\" id=\"product_id\" value='".$row["productId"]."'/>";
        $resultatRetourne.="<td>".$row["productId"]."</td>";
        $resultatRetourne.="<td>".$row["productPrice"]." $</td>";
        $resultatRetourne.="<td>".$row["productQuantity"]."</td>";
        $resultatRetourne.=" <td><input type=\"button\" id=\"update\" value=\"update\"/><input type=\"button\" id=\"delete\" value=\"Delete\"/>";
        $resultatRetourne.="</tr>";
        $counter++;
    }
    $resultatRetourne.="</table>";
    mysqli_close($con);
    echo $resultatRetourne;
?>