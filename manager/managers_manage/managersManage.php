<?php
include "../../db_con/connection.php";
session_start();
if(!isset($_SESSION["managerUser"]) && empty($_SESSION["managerUser"])){
    echo "<h1>You can't view this page</h1>.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="managersManageStyle.css"/>
    <title>Managers Manage</title>
</head>
<body>
    <div class="manager-manage-container">
        <div class="h-btn">
        <h1>Manager Managment Page</h1>
        <div class="btn">
        <a href="../../manager/managers_home/managerHome.php"><input type="button" class="btn-home" value="manager Home Page"/></a>
        <form method="POST" action="../logoutManager.php">
        <input type="submit" value="Log out"/>
        </form>
    </div>
        </div>
        <div class="manager-details">
        </div>
    <hr></hr>
    
    <div class="manager-update">
        <form method="POST" action="../../general_functions_classes/update.php">
        <h3>Update Manager</h3>
        <table>
            <tr>
                <td>Manager ID</td>
                <td><input type="text" id="managerId" name="managerId" readonly/>
            </tr>
            <tr>
                <td>User name</td>
                <td><input type="text" id="nameU" name="managername"></td>
            </tr>
        <tr>
        <tr>
            <td>Email</td>
            <td><input type="email" id="emailU" class="adjust-inp" name="email"/></td>
        </tr>
        
        <tr>
            <td>Password</td>
            <td><input type="password" id="passU" class="adjust-inp" name="pass"/></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Update"/></td>
        </tr>
    </form>
        </table>
</div>
    <div class="manager-add">
        <h3>Add a new Manager</h3>
        <p class="info"></p>
        <table>
            <tr>
                <td>User name</td>
                <td><input type="text" id="name" name="mname"></td>
            </tr>
        <tr>
        <tr>
            <td>Email</td>
            <td><input type="email" id="email" class="adjust-inp" name="email"/></td>
        </tr>
        
        <tr>
            <td>Password</td>
            <td><input type="password" id="pass" class="adjust-inp" name="pass"/></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="button" id="add" value="Add"/></td>
        </tr>
        </table>
    </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        refreshManagers();
        $(".manager-update").hide();
        //si on veut changer les infos d'un manager existant
        $(".manager-details").on('click','#update',function(){
            var tableName="manager";
            var parent=$(this).parent().parent().attr("id");
           var managerId=$("#"+parent+" #m_id").val();
            $.ajax({
                type:"POST",
                dataType:"JSON",
            url:"../../ajax/operations/showUpdate.php",
           data:{managerId:managerId,table:tableName},
           success:function(response){
                   $(".manager-update").show();
                   //remplir les inputs
                   $("#managerId").attr("value",response[0].managerId);
                   $("#nameU").attr("value",response[0].username);
                   $("#emailU").attr("value",response[0].email);
                   $("#passU").attr("value",response[0].password);
               }
            })
        })
        //si on veut ajouter un manager
       $("#add").click(function(){
           var name=$("#name").val();
           var email=$("#email").val();
           var pass=$("#pass").val();
           var tableName="manager";
        $.ajax({
           type:"POST",
           url:"../../ajax/operations/adding.php",
           data:{username:name,password:pass,email:email,table:tableName},
           success:function(response){
            $(".info").empty();
               $(".info").append(response);
               //mettre a jour table des managers
               refreshManagers();
               }
           })
       })
       //si on veut supprimer un manager
       $(".manager-manage-container").on('click','#delete',function(){
           //parent
           var parent=$(this).parent().parent().attr("id");
           var managerId=$("#"+parent+" #m_id").val();
           var tableName="manager";
           //envoye managerId a deleting
           $.ajax({
           type:"POST",
           url:"../../ajax/operations/deleting.php",
           data:{managerId:managerId,table:tableName},
           success:function(response){
              refreshManagers();
               }
           })
       });

       //function pour mettre a jour la table des managers
       function refreshManagers(){
        $.ajax({
           type:"POST",
           url:"../../ajax/refresh/refreshManagers.php",
           success:function(response){
               $(".manager-details").empty();
               $(".manager-details").append("<h3>Managers</h3>");
               $(".manager-details").append(response);
               }
           })
       }

    })

</script>
</body>
</html>