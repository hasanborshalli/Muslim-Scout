<?php
require_once ("config.php");
session_start();
try{
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!="Leader")){
        header("Location:logout.php");
        exit;
      }
$pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
if(isset($_POST['titleRequest'],$_POST['descriptionRequest'],$_POST['locationRequest'])){
    extract($_POST);
    $id=$_SESSION['id']; 
    echo"$titleRequest<br>$descriptionRequest<br>$locationRequest<br>";
    $queryRequestActivity="INSERT into requestedActivities values ('','$titleRequest','$descriptionRequest','$locationRequest','$id','false')";
    $resultRequestActivity=$pdo->exec($queryRequestActivity);
}
header("Location:Activity.php");
}catch(PDOException $e){
    die($e->getMessage());
    }
?>