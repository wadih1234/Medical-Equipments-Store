<?php
include "../db_con/connection.php";
$checker=true;
$error="";
//si update client
if(isset($_POST["clientId"]) && !empty($_POST["clientId"]) && isset($_POST["fname"]) && !empty($_POST["fname"]) && isset($_POST["lname"])
&& !empty($_POST["lname"]) && isset($_POST["city"]) && !empty($_POST["city"])
&& isset($_POST["mobile"]) && !empty($_POST["mobile"]) && isset($_POST["email"])
&& !empty($_POST["email"]) && isset($_POST["discount"]) && !empty($_POST["discount"])){
    $clientId=$_POST["clientId"];
    $fname=validate_input($_POST["fname"]);
    $lname=validate_input($_POST["lname"]);
    $mobile=validate_input($_POST["mobile"]);
    $email=validate_input($_POST["email"]);
    $city=validate_input($_POST["city"]);
    $discount=validate_input($_POST["discount"]);
    //validation
    if(!preg_match("/^[a-zA-Z]+$/",$fname)){
        $checker=false;
        }
    
    if(!preg_match("/^[a-zA-Z]+$/",$lname)){
         $checker=false;
            }

    if(!preg_match("/^[0-9]+$/",$mobile)){
        $checker=false;
        }
        
       if(!preg_match("/^\w+@\w+[.]\w+$/",$email)){
        $checker=false;
        }
        
       if(!preg_match("/^\w+$/",$city)){
        $error.="city cannot contains numbers<br>";
        $checker=false;
        }
        
       if(!preg_match("/^\w+$/",$discount) || $discount>100){
        $checker=false;
        }
    if($checker){
        //requete de changement
        $requete="update clients set firstName='$fname',lastName='$lname', mobile=$mobile,city='$city',email='$email',discount=$discount where clientId=$clientId";
        mysqli_query($con,$requete);
        mysqli_close($con);
    }
    header("Location:../manager/clients_manage/clientsManage.php");
}

//si update manager
if(isset($_POST["managerId"]) && !empty($_POST["managerId"]) && isset($_POST["managername"]) && !empty($_POST["managername"]) && isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["pass"]) && !empty($_POST["pass"])){
    $managerId=$_POST["managerId"];
    $username=$_POST["managername"];
    $email=$_POST["email"];
    $pass=$_POST["pass"];
    if(!preg_match("/^\w+$/",$username)){
        $checker=false;
    }
    if(!preg_match("/^\w+$/",$pass)){
        $checker=false;
    }
    if(!preg_match("/^\w+@\w+[.]\w+$/",$email)){
        $checker=false;
    }
    if($checker){
        //requete de changement
        $requete="update manager set username='$username',email='$email',password='$pass' where managerId=$managerId";
        mysqli_query($con,$requete);
        mysqli_close($con);
    }
    header("Location:../manager/managers_manage/managersManage.php");
}
//si update company
if(isset($_POST["companyId"]) && !empty($_POST["companyId"]) && isset($_POST["name"]) && !empty($_POST["name"])  && isset($_POST["city"]) && !empty($_POST["city"])
&& isset($_POST["mobile"]) && !empty($_POST["mobile"]) && isset($_POST["email"])
&& !empty($_POST["email"]) && isset($_POST["discount"]) && !empty($_POST["discount"])){
    $companyId=$_POST["companyId"];
    $companyName=$_POST["name"];
    $mobile=$_POST["mobile"];
    $email=$_POST["email"];
    $city=$_POST["city"];
    $discount=$_POST["discount"];
    if(!preg_match("/^[a-zA-Z]+$/",$companyName)){
        $error.="Company name must contains only letters<br>";
        $checker=false;
   }
   
   if(!preg_match("/^[0-9]+$/",$mobile)){
    $error.="Mobile must contains only numbers<br>";
    $checker=false;
    }
    
   if(!preg_match("/^\w+@\w+[.]\w+$/",$email)){
    $error.="email contains errors<br>";
    $checker=false;
    }
    if(!preg_match("/^\w+$/",$city)){
        $error.="city cannot contains numbers<br>";
        $checker=false;
        }
    if($checker){
        //requete de changement
        $requete="update company set companyName='$companyName',mobile=$mobile,city='$city',email='$email',discount=$discount where companyId=$companyId";
        mysqli_query($con,$requete);
        mysqli_close($con);
    }
  header("Location:../manager/companies_manage/companiesManage.php");
}

//si order update
if(isset($_POST["orderId"]) && !empty($_POST["orderId"])){
    $requete="Update orders set status='D' where orderId=".$_POST["orderId"];
    mysqli_query($con,$requete);
    mysqli_close($con);
}














function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>