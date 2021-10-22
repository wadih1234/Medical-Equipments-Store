<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="managerLoginStyle.css"/>
    <title>Manager login</title>
</head>
<body>
    <div class="manager-login-container">
    <h2>Manager Log In</h2>
    <?php if(isset($_GET["error"]) && !empty($_GET["error"])) echo "<p>".$_GET["error"]."</p>";?>
    <form method="POST" action="managerLoginHandler.php">
        <table>
        <tr><td>Username:</td>
        <td><input type="text" name="username"/></td>
        <tr><td>Email:</td>
        <td><input type="email" name="email"/></td>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="pass"/></td>
        </tr>
    </table>
    <input type="submit"/><input type="reset"/>
    </form>
    </div>
</body>
</html>