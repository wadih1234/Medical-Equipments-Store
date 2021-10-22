<?php
session_start();
if(!isset($_SESSION["managerUser"]) && empty($_SESSION["managerUser"])){
    echo "<h1>You can't access this page</h1>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="managerHome.css"/>
    <title>Manager Home</title>
</head>
<body>
    <div class="manager-home-container">
    <h2>Welcome Manager<h2>
    <h3>Choose one from these options</h3>
    <div class="options">
        <a href="../clients_manage/clientsManage.php">
        <div class="option-div">
        <h3>Clients managment</h3>
        <p><i>Add/Update/Delete clients and the ability to give clients discounts.</i></p> 
        </div>
        </a>
        <a href="../companies_manage/companiesManage.php">
        <div class="option-div">
        <h3>Companies managment</h3>
        <p><i>Add/Update/Delete companies and the ability to give companies discounts.</i></p> 
        </div>
        </a>
        <a href="../managers_manage/managersManage.php">
    <div class="option-div">
        <h3>Managers managment</h3>
        <p><i>Add/Update/Delete managers</i></p> 
        </div>
        </a>
        <a href="../products_manage/productsManage.php">
    <div class="option-div">
        <h3>Products managment</h3>
        <p><i>Add/Update/Delete products and categories/subcategories </i></p> 
        </div>
        </a>
        <a href="../web_options/webOptions.php">
    <div class="option-div">
        <h3>Website options</h3>
        <p><i>Check website statistics and view messages sent by clients and view orders.</i></p> 
    </div>
        </a>
    </div>
    </div>
</body>
</html>