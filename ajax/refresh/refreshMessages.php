<?php
include "../../db_con/connection.php";
$resultat="";
    $requete="select messageId,userId,email,message from messages";
    $result=mysqli_query($con,$requete);
    $resultat="<table class=\"messages-table\">";
    $resultat.="<tr>";
    $resultat.="<th>User ID</th>";    
    $resultat.="<th>email</th>";    
    $resultat.="<th>message</th>";    
    $resultat.="<th>Operation</th>";
    $counter=1;    
    while($row=mysqli_fetch_assoc($result)){
        $resultat.="<tr id=row$counter>";
        $resultat.="<input type=\"hidden\" id=\"m_id\" value='".$row["messageId"]."'/>";
        $resultat.="<td>".$row["userId"]."</td>";
        $resultat.="<td>".$row["email"]."</td>";
        $resultat.="<td>".$row["message"]."</td>";
        $resultat.="<td><input type=\"button\" id=\"delete\" value=\"Delete\"/>";
        $resultat.="</tr>";
        $counter++;
    }
    $resultat.="</table>";
    mysqli_close($con);
    echo $resultat;
?>