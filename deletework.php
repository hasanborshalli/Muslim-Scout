<?php
require_once ("config.php");
session_start();
$id=$_GET['id'];
try{
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!='Troop Leader')){
        header("Location:logout.php");
        exit;
      }
      $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $queryDeleteWork="Update volunteer set is_deleted='true' where id='$id'";
      $resultDeleteWork=$pdo->query($queryDeleteWork);
      header("Location:volunteer.php");

    }catch(PDOException $e){
        die($e->getMessage());
        }

?>