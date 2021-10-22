<?php
include "../../general_functions_classes/classes.php";
include "../../db_con/connection.php";
if(isset($_POST["table"]) && !empty($_POST["table"])){
    $tableName=$_POST["table"];
    switch($tableName){
        //si table est client
        case "client":
            if(isset($_POST["fName"]) && !empty($_POST["fName"]) && isset($_POST["lName"]) && !empty($_POST["lName"])
            && isset($_POST["date"]) && !empty($_POST["date"]) && isset($_POST["gender"]) && 
            !empty($_POST["gender"]) && isset($_POST["city"]) && !empty($_POST["city"]) && isset($_POST["mobile"]) && !empty($_POST["mobile"])
            && isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"])
            && !empty($_POST["password"])){
              $fname=$_POST["fName"];
                $lname=$_POST["lName"];
                $date=$_POST["date"];
                $city=$_POST["city"];
                $gender=$_POST["gender"];
                $mobile=$_POST["mobile"];
              $email=$_POST["email"];
                $password=$_POST["password"];
            //initialiser objet client
        $client=new Client($email,$mobile,$password,$city,$fname,$lname,$date,$gender);
            //validation
         if(!preg_match("/^[a-zA-Z]+$/",$fname)){
        $error.="First name must contains only letters<br>";
        }
    
            if(!preg_match("/^[a-zA-Z]+$/",$lname)){
          $error.="Last name must contains only letters<br>";
            }

                if(!preg_match("/^[0-9]+$/",$mobile)){
                $error.="Mobile must contains only numbers<br>";
         }
        
            if(!preg_match("/^\w+@\w+[.]\w+$/",$email)){
             $error.="email contains errors<br>";
             }
        
            if(!preg_match("/^\w{8,}$/",$password)){
             $error.="password length must be 8 or above<br>";
             }
                if(!$client->insertUser($con)){
             $error.="Client exists<br>";
         }
             else{
             $success="Client registred successfully";
             }
    
            if(!empty($error)) echo $error;
            if(!empty($success)) echo $success;
        break;           
}
       
        case "manager":
            if(isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"])
&& !empty($_POST["password"]) && isset($_POST["username"]) && !empty($_POST["username"]))
{
    $username=$_POST["username"];
    $password=$_POST["password"];
    $email=$_POST["email"];
    if(!preg_match("/^\w+$/",$username)){
        $error.="username must contains only letters and numbers<br>";
    }
    if(!preg_match("/^\w+$/",$password)){
        $error.="password must contains only letters and numbers<br>";
    }
    if(!preg_match("/^\w+@\w+[.]\w+$/",$email)){
        $error.="Incorrect email<br>";
    }
        $requete="insert into manager (email,username,password) values('$email','$username','$password')";
        mysqli_query($con,$requete);
        $success="Manager inserted successfully";
        mysqli_close($con);
        if(!empty($error)) echo $error;
        if(!empty($success)) echo $success;
}
    break;


            //si la table est company
            case "company":
        if(isset($_POST["companyName"]) && !empty($_POST["companyName"]) && isset($_POST["city"]) && !empty($_POST["city"]) && isset($_POST["mobile"]) && !empty($_POST["mobile"])
        && isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"])
        && !empty($_POST["password"])){
            $companyName=$_POST["companyName"];
            $mobile=$_POST["mobile"];
              $email=$_POST["email"];
                $password=$_POST["password"];
                $city=$_POST["city"];
            //cree objet company
     $company=new Company($email,$mobile,$password,$city,$companyName);
     //validation
    if(!preg_match("/^[a-zA-Z]+$/",$companyName)){
         $error.="Company name must contains only letters<br>";
    }
    
    if(!preg_match("/^[0-9]+$/",$mobile)){
     $error.="Mobile must contains only numbers<br>";
     }
     
    if(!preg_match("/^\w+@\w+[.]\w+$/",$email)){
     $error.="email contains errors<br>";
     }
     
    if(!preg_match("/^\w{8,}$/",$password)){
     $error.="password length must be 8 or above<br>";
     }
     if(!$company->insertUser($con)){
        $error.="Company exists<br>";
       
    }
    else{
        $success="Company registred successfully";
    }
    if(!empty($error)) echo $error;
    if(!empty($success)) echo $success;
        break;
}
    }


}
?>