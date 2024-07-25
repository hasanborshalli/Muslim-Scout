<?php
require_once ("config.php");
session_start();
$id=$_GET['id'];
try{
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!="It")){
        header("Location:login.php");
        exit;
      }
      $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $queryDeleteNew="Update news set is_deleted='true' where id='$id'";
      $resultDeleteNew=$pdo->query($queryDeleteNew);
      header("Location:it.php");

    }catch(PDOException $e){
        die($e->getMessage());
        }

?>