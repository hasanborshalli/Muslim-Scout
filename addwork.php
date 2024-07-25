<?php
require_once ("config.php");
session_start();


try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!='Troop Leader')){
        header("Location:logout.php");
        exit;
      }
    $district=$_SESSION['district'];
    $troop=$_SESSION['troop'];
if(isset($_POST['title'],$_POST['description'],$_POST['date'],$_POST['time'],$_POST['location'],$_POST['gathering'],$_POST['group'])){
    extract($_POST);
    $queryAddWork="INSERT into volunteer values ('','$title','$description','$date','$time','$location','$gathering','$district','$troop','$group','false')";
    $resultAddWork=$pdo->exec($queryAddWork);

    $queryGetRequested1="SELECT id from user where district='$district' and troop='$troop' and usergroup='$group' and role='Leader' and is_deleted='false'";
    $resultGetRequested1=$pdo->query($queryGetRequested1);
    $rowGetRequested1=$resultGetRequested1->fetch();

    $queryGetRequested2="SELECT id from user where district='$district' and role='Commander' and is_deleted='false'";
    $resultGetRequested2=$pdo->query($queryGetRequested2);
    $rowGetRequested2=$resultGetRequested2->fetch();

    $queryDeleteRequested="UPDATE requestedworks SET is_deleted='true' where title='$title' AND (userId='$rowGetRequested1[id]' or userId='$rowGetRequested2[id]')";
    $resultDeleteRequested=$pdo->exec($queryDeleteRequested);
}
header("location:volunteer.php");
}catch(PDOException $e){
    if($e->getCode()==23000){
        if (strpos($e->getMessage(), 'date') !== false){
            header("Location: error.php?error=dateWork");
        }
    }
    }
    ?>