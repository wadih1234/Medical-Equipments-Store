<?php
include "../header/header.php";
include "../db_con/connection.php";
$user="";
if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"])){
    $user=$_SESSION["clientId"];
}

if(isset($_SESSION["companyId"]) && !empty($_SESSION["companyId"])){
    $user=$_SESSION["companyId"];
}
$error="";
$checker=true;
if(isset($_POST["mail"]) && !empty($_POST["mail"]) && isset($_POST["message"])
&& !empty($_POST["message"])){
    $email=$_POST["mail"];
    $message=$_POST["message"];
    if(!preg_match("/^\w+@\w+[.]\w+$/",$email)){
        $error.="email contains errors<br>";
        $checker=false;
        }
    if(!preg_match("/^\w{10,}$/",$message)){
        $error="message must contains in minimum 10 characters";
        $checker=false;
    }
    if($checker){
        if(empty($user)){
            $requete="insert into messages(email,message) values('$email','$message')";    
        }
        else{
        $requete="insert into messages(userId,email,message) values($user,'$email','$message')";
        }
        mysqli_query($con,$requete);
        echo mysqli_error($con);
    }
    mysqli_close($con);
}

?>
<head>
    <link rel="stylesheet" href="contactUsStyle.css">
</head>

<h1>Contact us Page</h1>
<div class="contact-container">
    <div class="contact">
<h3>Please fill the form below.</h3>
<p class="error"><?php if(isset($error) && !empty($error)) echo $error?></p>
<form method="POST">
    <span class="spans">Email</span>
    <span class="spans"><input type="email" name="mail" class="input"/></span>
    <span class="spans">Message</span>
    <span class="spans"><textarea name="message" cols="35" rows="5"></textarea></span>
    <span class="spans"><input type="submit" value="send"/></span>
</form>
</div>

    <div class="info">
        <h3>Benefits of contacting us.</h3>
        <ul>
            <li>Ask about a specific product.</li>
            <li>Decline an order.</li>
            <li>Share you're product.</li>
        </ul>
    </div>
</div>

<?php
include "../footer/footer.php";
?>
