<?php
include "../../db_con/connection.php";
$resultat="";
    $requete="select managerId,username,email from manager";
    $result=mysqli_query($con,$requete);
    $resultat="<table class=\"managers-table\">";
    $resultat.="<tr>";
    $resultat.="<th>Manager username</th>";    
    $resultat.="<th>Manager email</th>";    
    $resultat.="<th>Operation</th>";
    $counter=1;    
    while($row=mysqli_fetch_assoc($result)){
        $resultat.="<tr id=row$counter>";
        $resultat.="<input type=\"hidden\" id=\"m_id\" value='".$row["managerId"]."'/>";
        $resultat.="<td>".$row["username"]."</td>";
        $resultat.="<td>".$row["email"]."</td>";
        $resultat.="<td><input type=\"button\" id=\"update\" value=\"Update\"/><input type=\"button\" id=\"delete\" value=\"Delete\"/>";
        $resultat.="</tr>";
        $counter++;
    }
    $resultat.="</table>";
    mysqli_close($con);
    echo $resultat;
?>