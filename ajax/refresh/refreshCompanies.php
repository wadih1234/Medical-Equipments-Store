<?php
include "../../db_con/connection.php";
$resultatRetourne="";
    $requete="select companyId,companyName,email,mobile,discount from company";
    $result=mysqli_query($con,$requete);
    
        $resultatRetourne.="<table class=\"companies-table\">";
        $resultatRetourne.="<tr>";
        $resultatRetourne.="<th>Company name</th>";
        $resultatRetourne.="<th>Mobile</th>";
        $resultatRetourne.="<th>Email</th>";
        $resultatRetourne.="<th>Discounts(%)</th>";
        $resultatRetourne.="<th>Operation</th>";
        $resultatRetourne.="</tr>";

    $counter=1;
    while($row=mysqli_fetch_assoc($result)){
        $resultatRetourne.="<tr id=row$counter>";
        $resultatRetourne.="<input type=\"hidden\" id=\"c_id\" value='".$row["companyId"]."'/>";
        $resultatRetourne.="<td>".$row["companyName"]."</td>";
        $resultatRetourne.="<td>".$row["mobile"]."</td>";
        $resultatRetourne.="<td>".$row["email"]."</td>";
        $resultatRetourne.="<td>".$row["discount"]."</td>";
        $resultatRetourne.="<td><input type=\"button\" id=\"update\" value=\"Update\"/><input type=\"button\" id=\"delete\" value=\"Delete\"/>";
        $resultatRetourne.="</tr>";
    $counter++;
    }
    $resultatRetourne.="</table>";
    mysqli_close($con);
    echo $resultatRetourne;
?>