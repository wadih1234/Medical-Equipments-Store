<?php
include "../../db_con/connection.php";
if(isset($_POST["table"]) && !empty($_POST["table"])){
    switch($_POST["table"]){
        case "manager":
            
                if(isset($_POST["managerId"]) && !empty($_POST["managerId"])){
                    $requete="Delete from manager where managerId=".$_POST["managerId"];
                    mysqli_query($con,$requete);
                }
               break;
        case "company":
                if(isset($_POST["companyId"]) && !empty($_POST["companyId"])){
                $requete="Delete from company where companyId=".$_POST["companyId"];
                mysqli_query($con,$requete);
                }
            break;
        case "client":
            if(isset($_POST["clientId"]) && !empty($_POST["clientId"])){
            $requete="Delete from clients where clientId=".$_POST["clientId"];
            mysqli_query($con,$requete);
            }
        break;
        case "messages":
            if(isset($_POST["messageId"]) && !empty($_POST["messageId"])){
                $requete="Delete from messages where messageId=".$_POST["messageId"];
            mysqli_query($con,$requete);
            }
        break;
        case "orders":
            if(isset($_POST["orderId"]) && !empty($_POST["orderId"])){
                $requete="Delete from orders where orderId=".$_POST["orderId"];
            mysqli_query($con,$requete);
            }
            break;
        
        case "category":
                if(isset($_POST["categoryId"]) && !empty($_POST["categoryId"])){
                    $requete="select categorySrc from categories where categoryId=".$_POST["categoryId"];
                    $result=mysqli_query($con,$requete);
                    $row=mysqli_fetch_assoc($result); 
                    echo rmdir($row["categorySrc"]);
                    $requete="Delete from categories where categoryId=".$_POST["categoryId"];
                mysqli_query($con,$requete);
                //supprimer encore les subcategories de cette category
                $requete="Delete from subcategories where categoryId=".$_POST["categoryId"];
                mysqli_query($con,$requete);
                }
                break;
                case "subcategory":
                if(isset($_POST["subcategoryId"]) && !empty($_POST["subcategoryId"])){
                    $requete="select subcategorySrc from subcategories where subcategoryId=".$_POST["subcategoryId"];
                    $result=mysqli_query($con,$requete);
                    $row=mysqli_fetch_assoc($result); 
                    echo rmdir($row["subcategorySrc"]);
                    $requete="Delete from subcategories where subcategoryId=".$_POST["subcategoryId"];
                mysqli_query($con,$requete);
                }
                break;
    case "products":
            if(isset($_POST["productId"]) && !empty($_POST["productId"])){
                $requete="Delete from products where productId=".$_POST["productId"];
            mysqli_query($con,$requete);
            }
    }
}
?>