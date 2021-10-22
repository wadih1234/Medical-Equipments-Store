<?php
include "../../db_con/connection.php";
$returned_Array=[];
if(isset($_POST["table"]) && !empty($_POST["table"])){
    $tablename=$_POST["table"];
    switch($tablename){
        //si la table est manager
        case "manager":
            if(isset($_POST["managerId"]) && !empty($_POST["managerId"])){
                $managerId=$_POST["managerId"];
                $requete="select managerId,username,password,email from manager where managerId=".$managerId;
                $result=mysqli_query($con,$requete);
                while($row=mysqli_fetch_assoc($result)){
                $returned_Array[]=array(
                    "managerId" => $row["managerId"],
                    "username" => $row["username"],
                    "password" => $row["password"],
                    "email" => $row["email"],
                );
            }
                echo json_encode($returned_Array);
            }
            break;
        
        //si la table est client
        case "clients":
            if(isset($_POST["clientId"]) && !empty($_POST["clientId"])){
                $clientId=$_POST["clientId"];
                $requete="select clientId,firstName,lastName,mobile,email,city,gender,date,discount from clients where clientId=".$clientId;
                $result=mysqli_query($con,$requete);
                while($row=mysqli_fetch_assoc($result)){
                $returned_Array[]=array(
                    "clientId" => $row["clientId"],
                    "firstName" => $row["firstName"],
                    "lastName" => $row["lastName"],
                    "mobile" => $row["mobile"],
                    "email" => $row["email"],
                    "city" => $row["city"],
                    "gender" => $row["gender"],
                    "date" => $row["date"],
                    "discount" => $row["discount"],
                );
            }
                echo json_encode($returned_Array);
            }
            break; 
        //si la table est company
        case "company":
            if(isset($_POST["companyId"]) && !empty($_POST["companyId"])){
                $companyId=$_POST["companyId"];
                $requete="select companyId,companyName,mobile,email,city,discount from company where companyId=".$companyId;
                $result=mysqli_query($con,$requete);
                while($row=mysqli_fetch_assoc($result)){
                $returned_Array[]=array(
                    "companyId" => $row["companyId"],
                    "companyName" => $row["companyName"],
                    "mobile" => $row["mobile"],
                    "email" => $row["email"],
                    "city" => $row["city"],
                    "discount" => $row["discount"],
                );
            }
               echo json_encode($returned_Array);
            }
            break;            
         //si la table est products
        case "products":
            if(isset($_POST["productId"]) && !empty($_POST["productId"])){
                $productId=$_POST["productId"];
                $requete="select productId,productName,productPrice,productQuantity from products where productId=".$productId;
                $result=mysqli_query($con,$requete);
                while($row=mysqli_fetch_assoc($result)){
                $returned_Array[]=array(
                    "productId" => $row["productId"],
                    "productName" => $row["productName"],
                    "productPrice" => $row["productPrice"],
                    "productQuantity" => $row["productQuantity"]
                );
            }
                echo json_encode($returned_Array);
            }
            break;    
    }
}

?>