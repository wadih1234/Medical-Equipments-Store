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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="clientsManageStyle.css"/>
    <title>Clients Manage</title>
</head>
<body>
    <div class="client-manage-container">
        <div class="h-btn">
        <h1>Client Managment Page</h1>
        <div class="btn">
        <a href="../../manager/managers_home/managerHome.php"><input type="button" class="btn-home" value="manager Home Page"/></a>
        <form method="POST" action="../logoutManager.php">
        <input type="submit" value="Log out"/>
        </form>
    </div>
        </div>
        <p><i>This section is for updating/deleting a client.</i></p>
        <div class="client-details">
        </div>
    <hr></hr>

    <div class="client-update">
        <h3>Update Client</h3>
        <form method="POST" action="../../general_functions_classes/update.php">
        <table>
            <tr>
                <td>Client ID</td>
                <td><input type="text" id="clientId" name="clientId" readonly/></td>
            </tr>
            <tr>
                <td>First name</td>
                <td><input type="text" id="fnameU" name="fname"></td>
            </tr>
             <tr>
                <td>Last name</td>
                <td><input type="text" id="lnameU" name="lname"></td>
            </tr>
        <tr>
            <td>City</td>
            <td><input type="text" class="adjust-inp" id="citynameU" name="city"/></td>
        </tr>
        <tr>
            <td>Mobile no.</td>
            <td><input type="text" class="adjust-inp" id="mobileU" name="mobile"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" class="adjust-inp" id="emailU" name="email"/></td>
        </tr>
        <tr>
            <td>Discount(%)</td>
            <td><input type="text" class="adjust-inp" id="discount" name="discount"/></td>
        <tr>
            <td></td>
            <td><input type="submit"  value="Update"/></td>
        </tr>
        </table>
    </form>
</div>

    <div class="client-add">
        <h3>Add a new Client</h3>
            <p><i>This section is for adding a new client.</i></p>
        <table>
            <tr>
                <td>First name</td>
                <td><input type="text" id="fname"></td>
            </tr>
             <tr>
                <td>Last name</td>
                <td><input type="text" id="lname"></td>
            </tr>

        <tr>
            <td>Birth date</td>
            <td><input type="date" class="adjust-inp" id="date"/></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td><input type="radio" id ="gender" name="gender" value="female"/>   Female
            <input type="radio" id="gender" name="gender" value="male"/>    Male</td>

        </tr>
        <tr>
            <td>City</td>
            <td><input type="text" class="adjust-inp" id="cityname"/></td>
        </tr>
        <tr>
            <td>Mobile no.</td>
            <td><input type="text" class="adjust-inp" id="mobile"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" class="adjust-inp" id="email"/></td>
        </tr>
        
        <tr>
            <td>Password</td>
            <td><input type="password" class="adjust-inp" id="pass"/></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="button" id="add" value="Add"/></td>
        </tr>
        </table>
    </div>
    </div>
    <script>
    $(document).ready(function(){
        refreshClients();
        $(".client-update").hide();
        //si on veut changer les infos d'un client existant
        $(".client-details").on('click','#update',function(){
            var tableName="clients";
            var parent=$(this).parent().parent().attr("id");
           var clientId=$("#"+parent+" #cl_id").val();
            $.ajax({
                type:"POST",
                dataType:"JSON",
            url:"../../ajax/operations/showUpdate.php",
           data:{clientId:clientId,table:tableName},
           success:function(response){
                   $(".client-update").show();
                   //remplir les inputs
                   $("#clientId").attr("value",response[0].clientId);
                   $("#fnameU").attr("value",response[0].firstName);
                   $("#lnameU").attr("value",response[0].lastName);
                   $("#genderU").attr("value",response[0].gender);
                   $("#citynameU").attr("value",response[0].city);
                   $("#mobileU").attr("value",response[0].mobile);
                   $("#emailU").attr("value",response[0].email);
                   $("#discount").attr("value",response[0].discount);
               }
            })
        })


        //si on veut supprimer un client
       $(".client-manage-container").on('click','#delete',function(){
           //parent
           var parent=$(this).parent().parent().attr("id");
           var clientId=$("#"+parent+" #cl_id").val();
           var tableName="client";
           //envoye clientId a deleting
           $.ajax({
           type:"POST",
           url:"../../ajax/operations/deleting.php",
           data:{clientId:clientId,table:tableName},
           success:function(response){
            refreshClients();
               }
           })
       });

       //si on veut ajouter un client
       $("#add").click(function(){
           //variables
           var firstName=$("#fname").val();
           var lastName=$("#lname").val();
           var date=$("#date").val();
           var gender=$("#gender").val();
           var city=$("#cityname").val();
           var mobile=$("#mobile").val();
           var email=$("#email").val();
           var password=$("#pass").val();
           var tableName="client";
           //envoye ces variables a ajax
           $.ajax({
           type:"POST",
           url:"../../ajax/operations/adding.php",
           data:{fName:firstName,lName:lastName,date:date,gender:gender,city:city,mobile:mobile,email:email,password:password,table:tableName},
           success:function(response){
                refreshClients();
               }
           });  
       });
    });







    //function pour mettre a jour la table des clients
    function refreshClients(){
        $.ajax({
           type:"POST",
           url:"../../ajax/refresh/refreshClients.php",
           success:function(response){
            $(".client-details").empty();
               $(".client-details").append("<h3>Clients</h3>");
               $(".client-details").append(response);
               }
           })
       }
    </script>
</body>
</html>