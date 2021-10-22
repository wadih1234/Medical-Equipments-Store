<?php
include "../../db_con/connection.php";
$resultatRetourne="";
    $requete="select subcategoryId,subCname,categoryId from subcategories";
    $result=mysqli_query($con,$requete);
    
        $resultatRetourne.="<table class=\"subcategories-table\">";
        $resultatRetourne.="<tr>";
        $resultatRetourne.="<th>Sub-Category ID</th>";
        $resultatRetourne.="<th>Sub-Category Name</th>";
        $resultatRetourne.="<th>Category ID</th>";
        $resultatRetourne.="<th>Operation</th>";
        $resultatRetourne.="</tr>";

    $counter=1;
    while($row=mysqli_fetch_assoc($result)){
        $resultatRetourne.="<tr id=\"row$counter\">";
        $resultatRetourne.="<input type=\"hidden\" id=\"subcategorie_id\" value='".$row["subcategoryId"]."'/>";
        $resultatRetourne.="<td>".$row["subcategoryId"]."</td>";
        $resultatRetourne.="<td>".$row["subCname"]."</td>";
        $resultatRetourne.="<td>".$row["categoryId"]."</td>";
        $resultatRetourne.=" <td><input type=\"button\" id=\"delete\" value=\"Delete\"/>";
        $resultatRetourne.="</tr>";
        $counter++;
    }
    $resultatRetourne.="</table>";
    mysqli_close($con);
    echo $resultatRetourne;
?>