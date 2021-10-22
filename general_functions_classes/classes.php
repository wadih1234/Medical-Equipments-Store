<?php
//classe de Personne
//DEBUT CLASSE PERSONNE
abstract class Person{
    public $email;
    public $mobile;
    public $password;
    public $city;
    function __construct($email,$mobile,$password,$city){
        $this->email=$email;
        $this->password=$password;
        $this->mobile=$mobile;
        $this->city=$city;
    }
    abstract function insertUser($connection);
}
//FIN CLASSE PERSONNE



//classe client qui herite personne
//DEBUT CLASSE CLIENT
class Client extends Person{
    public $firstName;
    public $lastName;
    public $dateBirth;
    public $gender;
    function __construct($email,$mobile,$password,$city,$firstName,$lastName,$dateBirth,$gender){
        parent::__construct($email,$mobile,$password,$city);
        $this->firstName=$firstName;
        $this->lastName=$lastName;
        $this->dateBirth=$dateBirth;
        $this->gender=$gender;
    }
    function insertUser($connection){
        //verifier si ce client existe
        $requete="Select clientId from clients where firstName='$this->firstName' and lastName='$this->lastName' and mobile='$this->mobile' and email='$this->email'  and Date='$this->dateBirth' and gender='$this->gender' and city='$this->city'";
        $result=mysqli_query($connection,$requete);
        //si il n'existe pas
        if(mysqli_num_rows($result)==0){
            //inserer le client
            $hashedPassword=password_hash($this->password,PASSWORD_DEFAULT);
            $requeteInsert="INSERT INTO clients (firstName,lastName,mobile, email,password,Date,gender,city) VALUES ('$this->firstName', '$this->lastName', '$this->mobile', '$this->email', '$hashedPassword', '$this->dateBirth', '$this->gender', '$this->city')";
            mysqli_query($connection,$requeteInsert);
            mysqli_close($connection);
            return true;
        }
        //s'il existe
        mysqli_close($connection);
        return false;
    }
}
//FIN CLASSE CLIENT



//classe company qui herite personne
//DEBUT CLASSE COMPANY
class Company extends Person{
    public $companyName;
    function __construct($email,$mobile,$password,$city,$companyName){
        parent::__construct($email,$mobile,$password,$city);
        $this->companyName=$companyName;
    }
    function insertUser($connection){
        //verifier si la company existe
        $requete="Select companyId from company where companyName='$this->companyName' and mobile='$this->mobile' and email='$this->email' and city='$this->city'";
        $result=mysqli_query($connection,$requete);
        echo mysqli_error($connection);
        //si elle n'existe pas
        if(mysqli_num_rows($result)==0){
            $hashedPassword=password_hash($this->password,PASSWORD_DEFAULT);
            $requeteInsert="INSERT INTO company (companyName,mobile,email,password,city) VALUES ('$this->companyName', '$this->mobile', '$this->email', '$hashedPassword','$this->city')";
            mysqli_query($connection,$requeteInsert);
            mysqli_close($connection);
            return true;
        }
        //si elle existe
        mysqli_close($connection);
        return false;
    }
}
//FIN CLASSE COMPANY

//DEBUT CLASSE PRODUIT
class Product{
    public $productImage;
    public $productName;
    public $productQuantityNeeded;
    public $productPrice;
    function __construct(){}
    function fillProduct($connection,$productId){
        $requete="select productName,productimageSrc,productPrice from
        products where productId=$productId";
        $result=mysqli_query($connection,$requete);
        $row=mysqli_fetch_assoc($result);
        $this->productImage=$row["productimageSrc"];
        $this->productName=$row["productName"];
        $this->productPrice=$row["productPrice"];
    }
    function neededQuantity($qt){
        $this->productQuantityNeeded=$qt;
    }
    function addProductToCart($connection,$userId,$productId,$quantity){
        $requete="insert into cart (productId,productQtNeeded,productName,userId) values($productId,$quantity,'$this->productName',$userId)";
        $result=mysqli_query($connection,$requete);
    }

}






?>