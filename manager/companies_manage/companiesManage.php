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
    <link rel="stylesheet" href="companiesManageStyle.css"/>
    <title>Companies Manage</title>
</head>
<body>
    <div class="company-manage-container">
        <div class="h-btn">
        <h1>Company Managment Page</h1>
        <div class="btn">
        <a href="../../manager/managers_home/managerHome.php"><input type="button" class="btn-home" value="manager Home Page"/></a>
        <form method="POST" action="../logoutManager.php">
        <input type="submit" value="Log out"/>
        </form>
    </div>
        </div>
        <p><i>This section is for updating/deleting a company.</i></p>
        <div class="company-details">
        </div>
    <hr></hr>

    <div class="company-update">
        <h3>Update Company</h3>
        <form method="POST" action="../../general_functions_classes/update.php">
        <table>
            <tr>
                <td>Company ID</td>
                <td><input type="text" id="companyId" name="companyId" readonly/></td>
            </tr>
            <tr>
                <td>Company name</td>
                <td><input type="text" id="nameU" name="name"></td>
            </tr>
            <tr>
            <td>Mobile</td>
            <td><input type="text"  id="mobileU" name="mobile"/></td>
        </tr>
        <tr>
            <td>City</td>
            <td><input type="text" id="citynameU" name="city"/></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" id="emailU" name="email"></td>
        </tr>
        
        <tr>
            <td>Discount</td>
            <td><input type="text" id="discount" name="discount"/></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Update"/></td>
        </tr>
        </table>
        </form>
</div>




    <div class="company-add">
        <h3>Add a new Company</h3>
        <p><i>This section is for adding a new company.</i></p>
        <table>
            <tr>
                <td>Company name</td>
                <td><input type="text" id="name" name="name"></td>
            </tr>
            <tr>
            <td>Mobile</td>
            <td><input type="text"  id="mobile" name="mobile"/></td>
        </tr>
        <tr>
            <td>City</td>
            <td><input type="text" id="cityname" name="cityname"/></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" id="email" name="email"></td>
        </tr>
        
        <tr>
            <td>Password</td>
            <td><input type="password" id="password" name="pass"/></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="button" id="add" value="Add"/></td>
        </tr>
        </table>
</div>
</div>

</body>
<script>
$(document).ready(function(){
        refreshCompanies();
            $(".company-update").hide();
        //si on veut changer les infos d'une company existante
        $(".company-details").on('click','#update',function(){
            var tableName="company";
            var parent=$(this).parent().parent().attr("id");
           var companyId=$("#"+parent+" #c_id").val();
            $.ajax({
                type:"POST",
                dataType:"JSON",
                url:"../../ajax/operations/showUpdate.php",
            data:{companyId:companyId,table:tableName},
           success:function(response){
                   $(".company-update").show();
                   //remplir les inputs
                   $("#companyId").attr("value",response[0].companyId);
                   $("#nameU").attr("value",response[0].companyName);
                   $("#mobileU").attr("value",response[0].mobile);
                   $("#citynameU").attr("value",response[0].city);
                   $("#emailU").attr("value",response[0].email);
                   $("#discount").attr("value",response[0].discount);
               }
            })
        })



       //si on veut supprimer une company
       $(".company-manage-container").on('click','#delete',function(){
           //parent
           var parent=$(this).parent().parent().attr("id");
           var companyId=$("#"+parent+" #c_id").val();
           var tableName="company";
           //envoye companyId a deleting
           $.ajax({
           type:"POST",
           url:"../../ajax/operations/deleting.php",
           data:{companyId:companyId,table:tableName},
           success:function(response){
               console.log(response);
            refreshCompanies();
               }
           })
       });


       //si on veut ajouter une company
       $("#add").click(function(){
           //variables
           var companyName=$("#name").val();
           var city=$("#cityname").val();
           var mobile=$("#mobile").val();
           var email=$("#email").val();
           var password=$("#password").val();
           var tableName="company";
           //envoye ces variables a ajax
           $.ajax({
           type:"POST",
           url:"../../ajax/operations/adding.php",
           data:{companyName:companyName,city:city,mobile:mobile,email:email,password:password,table:tableName},
           success:function(response){
                refreshCompanies();
               }
           });
       });


       //function pour mettre a jour la table des managers
       function refreshCompanies(){
        $.ajax({
           type:"POST",
           url:"../../ajax/refresh/refreshCompanies.php",
           success:function(response){
               $(".company-details").empty();
               $(".company-details").append("<h3>Companies</h3>");
               $(".company-details").append(response);
               }
           })
       }

    })
</script>
</html>