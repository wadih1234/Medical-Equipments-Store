<?php
include "../../db_con/connection.php";
$resultatRetourne="";
    $requete="select categoryId,categoryName from categories";
    $result=mysqli_query($con,$requete);
    
        $resultatRetourne.="<table class=\"categories-table\">";
        $resultatRetourne.="<tr>";
        $resultatRetourne.="<th>Category ID</th>";
        $resultatRetourne.="<th> Category Name</th>";
        $resultatRetourne.="<th>Operation</th>";
        $resultatRetourne.="</tr>";

    $counter=1;
    while($row=mysqli_fetch_assoc($result)){
        $resultatRetourne.="<tr id=\"row$counter\">";
        $resultatRetourne.="<input type=\"hidden\" id=\"categorie_id\" value='".$row["categoryId"]."'/>";
        $resultatRetourne.="<td>".$row["categoryId"]."</td>";
        $resultatRetourne.="<td>".$row["categoryName"]."</td>";
        $resultatRetourne.=" <td><input type=\"button\" id=\"delete\" value=\"Delete\"/>";
        $resultatRetourne.="</tr>";
        $counter++;
    }
    $resultatRetourne.="</table>";
    mysqli_close($con);
    echo $resultatRetourne;
?>