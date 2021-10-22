<?php
include "../../db_con/connection.php";
$checker=true;
$destinationImg="";
$img="";
if(isset($_POST["pname"]) && !empty($_POST["pname"]) && isset($_POST["pprice"]) && !empty($_POST["pprice"]) &&
isset($_POST["pquantity"]) && !empty($_POST["pquantity"]) && isset($_POST["pcategory"]) && !empty($_POST["pcategory"])
&& isset($_POST["psubcategory"]) && !empty($_POST["psubcategory"]) && isset($_FILES["pimage"]) && !empty($_FILES["pimage"])){
    //variables
    $productName=validate_input($_POST["pname"]);
    $productPrice=validate_input($_POST["pprice"]);
    $productCategoryId=validate_input($_POST["pcategory"]);
    $productSubCategoryId=validate_input($_POST["psubcategory"]);
    $productQuantity=validate_input($_POST["pquantity"]);
    //validation
    if(!preg_match("/^\w+(\s+\w+)*$/",$productName)){
        $checker=false;
    }
    if(!preg_match("/^[0-9]+$/",$productPrice)){
        $checker=false;
    }
    if(!preg_match("/^[0-9]+$/",$productQuantity)){
        $checker=false;
    }

    //image validation et ajout
        $image=$_FILES["pimage"];
        //definition des types d'images valide
        $extensionsImages=["image/png","image/jpg","image/jpeg"];
        //si le file est une image
        if(in_array($image["type"],$extensionsImages)){
           //chercher categoryName et subcategoryName pour inserer l'image dans sa destination
           $categoryName_subcategoryNameRequete="select C.categoryName as categoryName,S.subCname as subcategoryName from categories C,subcategories S 
           where C.categoryId=$productCategoryId and S.subcategoryId=$productSubCategoryId and C.categoryId=S.categoryId";
           $result=mysqli_query($con,$categoryName_subcategoryNameRequete);
           $row=mysqli_fetch_assoc($result);
           //prendre l'extension originale c.a.d couper le nom du fichier en 2 parties pour prendre l'extension
           $fichierNomDecouper=explode(".",$image["name"]);
           $fichierExtension=$fichierNomDecouper[1];
           //ajouter underscore entre categorieName et entre subcategorieName et productName
           $categoryName=ajouter_underscore($row["categoryName"]);
           $subcategoryName=ajouter_underscore($row["subcategoryName"]);
           $destinationImg="../../imgs/categories_subcategories/".$categoryName."/".$subcategoryName."/".ajouter_underscore($productName). "." . $fichierExtension;
           move_uploaded_file($image["tmp_name"],$destinationImg);
           $destinationImg="../imgs/categories_subcategories/".$categoryName."/".$subcategoryName."/".ajouter_underscore($productName). "." . $fichierExtension;
    }
    else{
        $checker=false;
    }
    if(isset($_POST["pinfo"]) && !empty($_POST["pinfo"])){
        //si description existe
        $description=$_POST["pinfo"];
        }
         //si tous est valide insert le produit
    if($checker){
        $ajouterRequete="insert into products(productName,productCategory,productsubCategory,productQuantity,productPrice,productimageSrc,Description)values('$productName',$productCategoryId,$productSubCategoryId,$productQuantity , $productPrice,'$destinationImg','$description')"; 
        mysqli_query($con,$ajouterRequete);
        mysqli_close($con);
    }
    header("Location:productsManage.php");
}



function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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