<?php
include "../../db_con/connection.php";
if(isset($_POST["catName"]) && !empty($_POST["catName"])){
    $catName=$_POST["catName"];
    //cree le repertoire pour cette categorie
    $src="../../imgs/categories_subcategories/".ajouter_underscore($catName);
    if(!file_exists($src))
    mkdir("../../imgs/categories_subcategories/".ajouter_underscore($catName));
    $requete="insert into categories(categoryName,categorySrc) values('$catName','$src')";
    mysqli_query($con,$requete);
    header("Location:productsManage.php");
}
if(isset($_POST["subcname"]) && !empty($_POST["subcname"]) && isset($_POST["toCategory"])
&& !empty($_POST["toCategory"])){
    $subcatName=$_POST["subcname"];
    $categoryId=$_POST["toCategory"];
    $requete="select categoryName from categories where categoryId=".$categoryId;
    $result=mysqli_query($con,$requete);
    $row=mysqli_fetch_assoc($result);
      $src="../../imgs/categories_subcategories/".ajouter_underscore($row["categoryName"])."/".ajouter_underscore($subcatName);
    $requete="insert into subcategories(subCname,categoryId,subcategorySrc) values('$subcatName',$categoryId,'$src')";
    if(!file_exists($src))
    mkdir("../../imgs/categories_subcategories/".ajouter_underscore($row["categoryName"])."/".ajouter_underscore($subcatName));
    $requete="insert into subcategories(subCname,categoryId,subcategorySrc) values('$subcatName',$categoryId,'$src')";
    mysqli_query($con,$requete);
    header("Location:productsManage.php");
  }



function ajouter_underscore($txt){
    $txtArray=explode(" ",$txt);
    $resultat="";
  for($i=0;$i<count($txtArray);$i++){
    if($i==count($txtArray)-1) $resultat.=$txtArray[$i];
    else   $resultat.=$txtArray[$i]."_";
  }
  return $resultat;

}
?>