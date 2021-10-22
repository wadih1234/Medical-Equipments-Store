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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="webStyle.css"/>
    <title>Website/messages Manage</title>
</head>
<body>
    <div class="web-manage-container">
        <div class="h-btn">
        <h1>Messages/statistics Page</h1>
        <div class="btn">
    <a href="../../manager/managers_home/managerHome.php"><input type="button" class="btn-home" value="manager Home Page"/></a>
        <form method="POST" action="../logoutManager.php">
        <input type="submit" value="Log out"/>
        </form>
     </div>
    </div>
        <h3>Messages</h3>
        <p><i>This section is for viewing/deleting a message.</i></p>
        <div class="messages-details">
        </div>
    <hr></hr>
    <p><i>This section is for viewing/updating/deleting an order.</i></p>
    <div class="orders-details">
    </div>
    <hr></hr>
    <p><i>This section is for viewing website statistics.</i></p>
        <div id="chart1">
        </div>
        
        <div id="chart2">
        </div>
    </div>

    <script type="text/javascript">

      google.charts.load('current', {'packages':['corechart']});

  
      google.charts.setOnLoadCallback(drawChart);

    
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Category');
        data.addColumn('number', 'number of products');
        <?php
        $resultat="";
        //trouver pour chaque category nb de sub categories
        $requete="SELECT C.categoryName,count(*) AS nbSub from categories C,subcategories S where C.categoryId=S.categoryId group by C.categoryName";
        $result=mysqli_query($con,$requete);
    ?>
        data.addRows([
            <?php
            while($row = mysqli_fetch_assoc($result)){

            echo "['".$row['categoryName']."',".$row['nbSub']."],";
                }
                ?>
        ]);

        // Set chart options
        var options = {'title':'Number of sub categories in each category',
                        'is3D':true,
                       'width':600,
                       'height':600};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart1'));
        chart.draw(data, options);
       
      }   
    </script>

<script>
    $(document).ready(function(){
       refreshMessages();
       refreshOrders();

        //si on veut supprimer un message
        $(".web-manage-container .messages-details").on('click','#delete',function(){
           //parent
           var parent=$(this).parent().parent().attr("id");
           var messageId=$("#"+parent+" #m_id").val();
           var tableName="messages";
           //envoye messageId a deleting
           $.ajax({
           type:"POST",
           url:"../../ajax/operations/deleting.php",
           data:{messageId:messageId,table:tableName},
           success:function(response){
               console.log(response);
            refreshMessages();
               }
           })
       });

       //si on veut supprimer un order
       $(".web-manage-container .orders-details").on('click','#delete',function(){
           var parent=$(this).parent().parent().attr("id");
           var orderId=$("#"+parent+" #o_id").val();
           var tableName="orders";
           //envoye orderId a deleting
           $.ajax({
           type:"POST",
           url:"../../ajax/operations/deleting.php",
           data:{orderId:orderId,table:tableName},
           success:function(response){
               console.log(response);
            refreshOrders();
               }
           })
       });



    })


    function refreshMessages(){
        $.ajax({
           type:"POST",
           url:"../../ajax/refresh/refreshMessages.php",
           success:function(response){
               $(".messages-details").empty();
               $(".messages-details").append("<h3>Messages</h3>");
               $(".messages-details").append(response);
               }
           })
       }
       function refreshOrders(){
        $.ajax({
           type:"POST",
           url:"../../ajax/refresh/refreshOrders.php",
           success:function(response){
               $(".orders-details").empty();
               $(".orders-details").append("<h3>Orders</h3>");
               $(".orders-details").append(response);
               }
           })
       }
    

</script>
</body>
</html>