<?php
require_once ("config.php");
session_start();
$userId=$_SESSION['id'];
$workId=$_GET['id'];
try{
    if(!isset($_SESSION['loggedin'])){
        header("Location:login.php");
        exit;
      }
      $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $queryRegisterWork="Insert into registeredworks values ('$workId','$userId')";
      $resultRegisterWork=$pdo->exec($queryRegisterWork);
      header("location: volunteer.php");
    }catch(PDOException $e){
        die($e->getMessage());
        }

?>