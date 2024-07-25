<?php
require_once ("config.php");
session_start();
try{
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!="Commander")){
        header("Location:login.php");
        exit;
      }
$pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
if(isset($_POST['titleWork'],$_POST['descriptionWork'],$_POST['locationWork'])){
    extract($_POST);
    $id=$_SESSION['id']; 
    $queryRequestWork="insert into requestedworks values('','$titleWork','$descriptionWork','$locationWork','$id','false')";
    $resultRequestWork=$pdo->exec($queryRequestWork);
}
header("Location:volunteer.php");
}catch(PDOException $e){
    die($e->getMessage());
    }
?>