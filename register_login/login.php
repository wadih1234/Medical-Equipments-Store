
<head>
    <link rel="stylesheet" href="../register_login/loginStyle.css">
</head>
<?php
include "../header/header.php";
?>
<div class="container-login">
    <h1>Log in</h1>
    <?php 
    if(!empty($_GET["error"]))
    echo "<div class=\"error\">".$_GET["error"]."</div>";
    ?>
    <form method="POST" action="login_handler.php">
        <div>
            <span>Email</span>
            <span><input type="email" name="email" class="adjust-inp"/></span>
        </div>
        
        <div>
            <span>Password</span>
            <span><input type="password" name="pass" class="adjust-inp"/></span>
        </div>
        <div>
            <span>
                <input type="radio" name="accountType" id="cust"  value="client"/>  Client
                <input type="radio" name="accountType" id="comp" value="company"/>   Company
             </span>
        </div>
        <div>
            <span>Don't have an account? <a href="register.php">Register an account</a>
        </div>
        <div>
            <input type="submit" value="Log In"/>
        </div>
        
    </form>
</div>
<?php
include "../footer/footer.php";
?>
