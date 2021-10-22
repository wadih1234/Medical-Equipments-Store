<?php
include "../../db_con/connection.php";
$resultatRetourne="";
    $requete="select clientId,firstName,lastName,email,mobile,discount from clients";
    $result=mysqli_query($con,$requete);
    
        $resultatRetourne.="<table class=\"clients-table\">";
        $resultatRetourne.="<tr>";
        $resultatRetourne.="<th>First name</th>";
        $resultatRetourne.="<th>Last name</th>";
        $resultatRetourne.="<th>Mobile</th>";
        $resultatRetourne.="<th>Email</th>";
        $resultatRetourne.="<th>Discounts(%)</th>";
        $resultatRetourne.="<th>Operation</th>";
        $resultatRetourne.="</tr>";

    $counter=1;
    while($row=mysqli_fetch_assoc($result)){
        $resultatRetourne.="<tr id=\"row$counter\">";
        $resultatRetourne.="<input type=\"hidden\" id=\"cl_id\" value='".$row["clientId"]."'/>";
        $resultatRetourne.="<td>".$row["firstName"]."</td>";
        $resultatRetourne.="<td>".$row["lastName"]."</td>";
        $resultatRetourne.="<td>".$row["mobile"]."</td>";
        $resultatRetourne.="<td>".$row["email"]."</td>";
        $resultatRetourne.="<td>".$row["discount"]."</td>";
        $resultatRetourne.=" <td><input type=\"button\" id=\"update\" value=\"update\"/><input type=\"button\" id=\"delete\" value=\"Delete\"/>";
        $resultatRetourne.="</tr>";
        $counter++;
    }
    $resultatRetourne.="</table>";
    mysqli_close($con);
    echo $resultatRetourne;
?>