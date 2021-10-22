<?php
session_start();
include "../../db_con/connection.php";
$user="";
if(!isset($_SESSION["clientId"]) && empty($_SESSION["clientId"]) && !isset($_SESSION["companyId"]) && empty($_SESSION["companyId"])){
    exit();
}
    if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"])){
    $user=$_SESSION["clientId"];
    }
    else{
        $user=$_SESSION["companyId"];
    }
        $resultat="";
        $resultat.= "<table>";
        $resultat.= "<tr>";
        $resultat.= "<th>Product image</th>";
            $resultat.= "<th>Product name</th>";
           $resultat.= " <th>Product quantity</th>";
            $resultat.= "<th>Product price</th>";
            $resultat.= "<th>Operation</th>";
       $resultat.= "</tr>";
            $requete="select productId,productQtNeeded from Cart where userId=".$user;
            $result=mysqli_query($con,$requete);
            if(mysqli_num_rows($result)==0){
               echo  "No products found in your cart";
               exit();
            }
            $counter=1;
            while($row=mysqli_fetch_assoc($result)){
                $requete2="select productName,productimageSrc,productPrice from products where productId=".$row["productId"];
                $result2=mysqli_query($con,$requete2);
                while($row2=mysqli_fetch_assoc($result2)){
                $resultat.= "<tr id=\"row$counter\">";
                $resultat.= "<input type=\"hidden\" class=\"p_id\" value=".$row["productId"].">";
                $resultat.= "<td><span>Product image</span><img src=".$row2["productimageSrc"]."></td>";
                $resultat.= "<td><span>Product name</span>".$row2["productName"]."</td>";
                $resultat.= "<td><span>Product quantity Needed</span>".$row["productQtNeeded"]."</td>";
                $resultat.= "<td><span>Product price</span>".$row2["productPrice"] * $row["productQtNeeded"]."$</td>";
                $resultat.="<td><button class=\" delete cart-buttons adjust-btn\">Delete</button></td>";
                $resultat.="</tr>";
                $counter++;
            }
            }
            $resultat.="</table>";
        mysqli_close($con);
        echo $resultat;
?>