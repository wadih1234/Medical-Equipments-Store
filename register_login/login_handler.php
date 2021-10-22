<?php
include "../db_con/connection.php";
session_start();
if(isset($_POST["accountType"]) && !empty($_POST["accountType"])){
$checkbox=$_POST["accountType"];
$error="";
$checker=true;
if($checkbox=="client"){
    if(isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["pass"]) && !empty($_POST["pass"])){
        $email=validate_input($_POST["email"]);
        $pass=validate_input($_POST["pass"]);
       if(!preg_match("/^\w+@\w+[.]\w+$/",$email)){
        $error.="email contains errors<br>";
        $checker=false;
        }
        
       if(!preg_match("/^\w{8,}$/",$pass)){
        $error.="password length must be 8 or above<br>";
        $checker=false;
        }
        if($checker==true){
        $requete="select clientId,firstName,password,city from clients where email='$email'";
        $result=mysqli_query($con,$requete);
            if(mysqli_num_rows($result)==0){
                $error="Client does not exists";
            }
            else{
                $row=mysqli_fetch_assoc($result);
                if(!password_verify($pass,$row["password"])){
                    $error="Incorrect Email/Password combination";
                }
                else{
                    $_SESSION["clientName"]=$row["firstName"];
                    $_SESSION["clientId"]=$row["clientId"];
                    $_SESSION["city"]=$row["city"];
                    header("Location:../home/home.php");
                }
            }
        }  
    }
    if(!empty($error)){
        header("Location:login.php?error=$error");
    }
}


if($checkbox=="company"){
    if(isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["pass"]) && !empty($_POST["pass"])){
        $email=validate_input($_POST["email"]);
        $pass=validate_input($_POST["pass"]);
       if(!preg_match("/^\w+@\w+[.]\w+$/",$email)){
        $error.="email contains errors<br>";
        $checker=false;
        }
        
       if(!preg_match("/^\w{8,}$/",$pass)){
        $error.="password length must be 8 or above<br>";
        $checker=false;
        }
        if($checker==true){
        $requete="select companyId,companyName,password,city from company where email='$email'";
        $result=mysqli_query($con,$requete);
            if(mysqli_num_rows($result)==0){
                $error="Company does not exists";
            }
            else{
                $row=mysqli_fetch_assoc($result);
                if(!password_verify($pass,$row["password"])){
                    $error="Incorrect Email/Password combination";
                }
                else{
                    $_SESSION["companyName"]=$row["companyName"];
                    $_SESSION["companyId"]=$row["companyId"];
                    $_SESSION["city"]=$row["city"];
                    header("Location:../home/home.php");
                }
            }
        }  
    }
    if(!empty($error)){
        header("Location:login.php?error=$error");
    }
}
}
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>
