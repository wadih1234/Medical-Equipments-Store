<?php
include "../../db_con/connection.php";
$error="";
session_start();
if(isset($_POST["username"]) && !empty($_POST["username"]) && isset($_POST["pass"])
&& !empty($_POST["pass"]) && isset($_POST["email"]) && !empty($_POST["email"])){
    $username=$_POST["username"];
    $password=$_POST["pass"];
    $email=$_POST["email"];
    $requete="select username,password,email from manager where username='$username'
    and password='$password' and email='$email'";
    $result=mysqli_query($con,$requete);
    $row=mysqli_fetch_assoc($result);
    if($row["username"]!=$username || $row["password"]!=$password || $row["email"]!=$email){
        $error="Incorrect username/password/email";
        header("Location:managerLogin.php?error=".$error);
    }
    else{
        $_SESSION["managerUser"]=$username;
        header("Location:../managers_home/managerHome.php");
    }
}
?>