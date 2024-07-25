<?php
require_once ("config.php");
session_start();
$id=$_GET['id'];
try{
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!="Hr")){
        header("Location:logout.php");
        exit;
      }
      $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $queryDeleteUser="Update user set is_deleted='true' where id='$id'";
      $resultDeleteUser=$pdo->query($queryDeleteUser);
      header("Location:hr.php");

    }catch(PDOException $e){
        die($e->getMessage());
        }

?>