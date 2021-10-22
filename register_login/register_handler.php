<?php
include "../general_functions_classes/classes.php";
include "../db_con/connection.php";
//si un checkbox au moin est choisi
if(isset($_POST["accountType"]) && !empty($_POST["accountType"])){
$checkbox=$_POST["accountType"];
$error="";
$success="";
$checker=true;
//si le checkbox est un client
//PARTIE CLIENT
if($checkbox=="client"){
    if(isset($_POST["fname"]) && !empty($_POST["fname"]) && isset($_POST["lname"]) && !empty($_POST["lname"]) && isset($_POST["mobile"]) && !empty($_POST["mobile"]) && isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["pass"]) && !empty($_POST["pass"]) && (isset($_POST["pass2"])) && !empty($_POST["pass2"]) && isset($_POST["cityname"]) && !empty($_POST["cityname"])){
        $fname=validate_input($_POST["fname"]);
        $lname=validate_input($_POST["lname"]);
        $date=validate_input($_POST["date"]);
        $gender=validate_input($_POST["gender"]);
        $mobile=validate_input($_POST["mobile"]);
        $email=validate_input($_POST["email"]);
        $city=validate_input($_POST["cityname"]);
        $pass=validate_input($_POST["pass"]);
        $pass2=validate_input($_POST["pass2"]);
        //initialiser objet client
        $client=new Client($email,$mobile,$pass,$city,$fname,$lname,$date,$gender);
        //validation
        if(!preg_match("/^[a-zA-Z]+$/",$fname)){
            $error.="First name must contains only letters<br>";
            $checker=false;
            }
        
        if(!preg_match("/^[a-zA-Z]+$/",$lname)){
            $error.="Last name must contains only letters<br>";
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
            if(!preg_match("/^[a-zA-Z]+$/",$city)){
                $error.="city cannot contains numbers<br>";
                $checker=false;
            }
            
           if(!preg_match("/^\w{8,}$/",$pass)){
            $error.="password length must be 8 or above<br>";
            $checker=false;
            }
    
            if($pass2!=$pass){
                $error.="passwords don't match<br>";
            $checker=false;
            }
            if($checker){
            if(!$client->insertUser($con)){
                $error.="Client exists<br>";
            }
            else{
                $success="Client registred successfully";
            } 
        }   
    }
    else{
        $error="All fields are required.";
    }
    if(!empty($error)){
        header("Location:register.php?error=$error");
    }
    if(!empty($success)){
        header("Location:register.php?success=$success"); 
    }
}
//FIN PARTIE CLIENT
//DEBUT PARTIE COMPANY
else{
if(isset($_POST["compname"]) && !empty($_POST["compname"]) && isset($_POST["mobile"]) && !empty($_POST["mobile"]) && isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["pass"]) && !empty($_POST["pass"]) && (isset($_POST["pass2"])) && !empty($_POST["pass2"]) && isset($_POST["cityname"]) && !empty($_POST["cityname"])){
    $companyName=validate_input($_POST["compname"]);
    $mobile=validate_input($_POST["mobile"]);
    $email=validate_input($_POST["email"]);
    $pass=validate_input($_POST["pass"]);
    $pass2=validate_input($_POST["pass2"]);
    $city=validate_input($_POST["cityname"]);
     //cree objet company
     $company=new Company($email,$mobile,$pass,$city,$companyName);
     //validation
    if(!preg_match("/^[a-zA-Z]+$/",$companyName)){
         $error.="Company name must contains only letters<br>";
         $checker=false;
    }
    
    if(!preg_match("/^[0-9]+$/",$mobile)){
        $error.="Mobile must contains only numbers<br>";
        $checker=false;
     }
     
     if(!preg_match("/^[a-zA-Z]+$/",$city)){
        $error.="city cannot contains numbers<br>";
        $checker=false;
    }
    if(!preg_match("/^\w+@\w+[.]\w+$/",$email)){
        $error.="invalid email<br>";
        $checker=false;
     }
     
    if(!preg_match("/^\w{8,}$/",$pass)){
     $error.="password length must be 8 or above<br>";
     $checker=$false;
     }
     if($checker){
     if(!$company->insertUser($con)){
        $error.="Company exists<br>";
    }
    else{
        $success="Company registred successfully";
    }
}
}
else{
    $error="All fields are required.";
}
if(!empty($error)){
    header("Location:register.php?error=$error");
}
if(!empty($success)){
    header("Location:register.php?success=$success");
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