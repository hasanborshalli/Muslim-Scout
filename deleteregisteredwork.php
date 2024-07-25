<?php
require_once ("config.php");
session_start();
$userId=$_SESSION['id'];
$workId=$_GET['workId'];
try{
    if(!isset($_SESSION['loggedin'])){
        header("Location:login.php");
        exit;
      }
      $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $queryDeleteRegistered="Delete From registeredworks WHERE workId='$workId' and userId='$userId'";
      $resulteDeleteRegistered=$pdo->exec($queryDeleteRegistered);
      header("location:volunteer.php");
    }catch(PDOException $e){
        die($e->getMessage());
        }

?>