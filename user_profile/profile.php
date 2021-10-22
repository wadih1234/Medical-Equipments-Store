<?php
include "../header/header.php";
include "../db_con/connection.php";
$user="";
$userType="";
if(!isset($_SESSION["clientId"]) && empty($_SESSION["clientId"])
&& !isset($_SESSION["companyId"]) && empty($_SESSION["companyId"])){
    exit();
}
if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"])){
    $user=$_SESSION["clientId"];
    $userType="Client";
}

if(isset($_SESSION["companyId"]) && !empty($_SESSION["companyId"])){
    $user=$_SESSION["companyId"];
    $userType="Company";
}
?>
<head>
    <link rel="stylesheet" href="profileStyle.css">
</head>
<h1>Profile</h1>
<div class="profile-container">
    <div class="info profile-item">
    <h3>Account informations</h3>
        <div class="content">
       <?php 
       $requete="";
        //si il est un client
                if($userType=="Client"){
                    $requete="Select firstName,lastName,mobile,email,city,discount from clients where clientId=$user";
                    $result=mysqli_query($con,$requete);
                    while($row=mysqli_fetch_assoc($result)){
                    echo "<table>";
                    echo "<tr>";
                    echo "<td>First Name: </td>";
                    echo "<td>".$row["firstName"]."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Last Name: </td>";
                    echo "<td>".$row["lastName"]."</td>";
                    echo "</tr>";
                    echo "<td>Mobile: </td>";
                    echo "<td>".$row["mobile"]."</td>";
                    echo "<td></td>";
                    echo "<tr>";
                    echo "<td>Email: </td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>City: </td>";
                    echo "<td>".$row["city"]."</td>";
                    echo "<tr>";
                    echo "<td>Account type: </td>";
                    echo "<td>Client</td>";
                    echo "<tr>";
                    echo "<td>Discount</td>";
                    echo "<td>".$row["discount"]." %</td>";
                    echo "</tr>";
                    echo "</tr>";
                    }
                    echo "</table>";
                }
                if($userType=="Company"){
                    $requete="Select companyName,mobile,email,city,discount from company where companyId=$user";
                    $result=mysqli_query($con,$requete);
                        while($row=mysqli_fetch_assoc($result)){
                    echo "<table>";
                    echo "<tr>";
                    echo "<td>Company Name: </td>";
                    echo "<td>".$row["companyName"]."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Mobile: </td>";
                    echo "<td>".$row["mobile"]."</td>";
                    echo "<td></td>";
                    echo "<tr>";
                    echo "<td>Email: </td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>City: </td>";
                    echo "<td>".$row["city"]."</td>";
                    echo "<tr>";
                    echo "<td>Account type: </td>";
                    echo "<td>Company</td>";
                    echo "<tr>";
                    echo "<td>Discount</td>";
                    echo "<td>".$row["discount"]." %</td>";
                    echo "</tr>";
                    echo "</tr>";
                    }
                    echo "</table>";
                }
        ?>
        </div>
    </div>
    <div class="orders-history profile-item">
        <h3>Orders history</h3>    
        <div class="content">
        <table>
                <th>Date</th>
                <th>Price</th>
                <th>Adress</th>
                <th>Status</th>
                <th>Operation</th>
                <?php
                $requete="Select orderId,Date,price,adress,status from orders where userId=$user";
                    $result=mysqli_query($con,$requete);
                    $counter=1;
                    while($row=mysqli_fetch_assoc($result)){
                        echo "<tr id='row$counter'>";
                        echo "<input type=hidden id=\"o_id\"  value='".$row["orderId"]."' >";
                        echo "<td>".$row["Date"]."</td>";
                        echo "<td>".$row["price"]." $ </td>";
                        echo "<td>".$row["adress"]."</td>";
                        echo "<td>".$row["status"]."</td>";
                        echo "<td><input type=\"button\" id=\"update\" value=\"update\"/></td>";
                        echo "</tr>";
                        $counter++;
                    }
                echo "</table>";
                ?>
            </table>
        </div>
    </div>
    <div class="messages profile-item">
        <h3>Messages</h3>
        <div class="content">
        <table>
                <th>From Email</th>
                <th>Message</th>
                <?php
                $requete="Select email,message from messages where userId=$user";
                    $result=mysqli_query($con,$requete);
                    while($row=mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>".$row["email"]."</td>";
                        echo "<td>".$row["message"]."</td>";
                        echo "</tr>";
                    }
                echo "</table>";
                ?>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".orders-history ").on('click','#update',function(){
            var tableName="orders";
            var parent=$(this).parent().parent().attr("id");
           var orderId=$("#"+parent+" #o_id").val();
           $.ajax({
                type:"POST",
                url:"../general_functions_classes/update.php",
            data:{orderId:orderId,table:tableName},
            success:function(response){
                refreshOrders();
            }
        })
    })
    function refreshOrders(){
        $.ajax({
                type:"POST",
                url:"changedOrders.php",
            success:function(response){
                $(".orders-history").empty();
                $(".orders-history").append(response);
            }
        })
    }
    });
</script>


<?php
include "../footer/footer.php";
?>