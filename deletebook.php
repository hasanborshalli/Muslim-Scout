<?php
require_once ("config.php");
session_start();
$id=$_GET['id'];
try{
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!="It")){
        header("Location:logout.php");
        exit;
      }
      $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $queryDeleteBook="Update library set is_deleted='true' where id='$id'";
      $resultDeleteBook=$pdo->query($queryDeleteBook);
      header("Location:it.php");

    }catch(PDOException $e){
        die($e->getMessage());
        }

?>