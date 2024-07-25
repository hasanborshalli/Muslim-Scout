<?php
session_start();
require_once ("config.php");
try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    if((!isset($_SESSION['loggedin'])) || ($_SESSION['role']!='Commander')){
        header("Location:logout.php");
        exit;
    }
    if(isset($_GET['email'],$_GET['issue'])){
        
        $queryDeleteFeedback="update feedbacks set is_deleted='true' where email='".$_GET['email']."' AND  issue='".$_GET['issue']."'";
        $resultDeleteFeedback=$pdo->exec($queryDeleteFeedback);
    }
}catch(PDOException $e){
    die($e->getMessage());
    }
    header('location:showFeedbacks.php');
  ?>