<?php
include "../../db_con/connection.php";
$resToSend="";
if(isset($_POST["catId"]) && !empty($_POST["catId"])){
 $requete="select subCname,subcategoryId from subcategories where categoryId=".$_POST["catId"];
 $resultat=mysqli_query($con,$requete);
 if(mysqli_num_rows($resultat)>0){
     while($row=mysqli_fetch_assoc($resultat)){
         $resToSend.="<option value=".$row["subcategoryId"].">".$row["subCname"]."</option>";
     }
 }
 else{
     echo "<option>-- Select subcategory --</option>";
 }
 mysqli_close($con);
 echo $resToSend;
}
?>