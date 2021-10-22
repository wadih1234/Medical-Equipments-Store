<?php
include "../db_con/connection.php";
$returned_Array=[];
if(isset($_POST["productId"]) && !empty($_POST["productId"])){
    $productId=$_POST["productId"];
    $requete="select productId,productName,productimageSrc,productPrice,productQuantity,companyId,Description from products where productId=$productId";
    $result=mysqli_query($con,$requete);
    while($row=mysqli_fetch_assoc($result)){
         $returned_Array[]=array(
                "productId" => $row["productId"],
                "productImage" => $row["productimageSrc"],
                "productPrice" => $row["productPrice"],
                "productDescription" => $row["Description"],
                "productQuantity" => $row["productQuantity"],
                "companyId" => $row["companyId"],
                "productName" => $row["productName"]
        );

      
    }
echo json_encode($returned_Array);
mysqli_close($con);
}
?>