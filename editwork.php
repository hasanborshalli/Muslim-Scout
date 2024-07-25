<?php

 require_once ("config.php");
 session_start();

 try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!='Troop Leader')){
        header("Location:logout.php");
        exit;
    }
       if(isset($_POST['titleEdit'],$_POST['descriptionEdit'],$_POST['dateEdit'],$_POST['timeEdit'],$_POST['locationEdit'],$_POST['gatheringEdit'],$_POST['groupEdit'])){
        extract($_POST);
        $queryGetInfo="Select * from volunteer where id='$idEdit' and is_deleted='false'";
        $resultGetInfo=$pdo->query($queryGetInfo);
        $rowGetInfo=$resultGetInfo->fetch();

       }
            if($rowGetInfo['title']!="$titleEdit"){
                $queryUpdatetitle="UPDATE volunteer SET title='$titleEdit' Where id='$idEdit'";
                $resultUpdatetitle=$pdo->exec($queryUpdatetitle);
            }
            if($rowGetInfo['description']!="$descriptionEdit"){
                $queryUpdatedescription="UPDATE volunteer SET description='$descriptionEdit' Where id='$idEdit'";
                $resultUpdatedescription=$pdo->exec($queryUpdatedescription);
            }
            if($rowGetInfo['date']!="$dateEdit"){
                $queryUpdatedate="UPDATE volunteer SET date='$dateEdit' Where id='$idEdit'";
                $resultUpdatedate=$pdo->exec($queryUpdatedate);
            }
            if($rowGetInfo['time']!="$timeEdit"){
                $queryUpdatetime="UPDATE volunteer SET time='$timeEdit' Where id='$idEdit'";
                $resultUpdatetime=$pdo->exec($queryUpdatetime);
            }
            if($rowGetInfo['location']!="$locationEdit"){
                $queryUpdatelocation="UPDATE volunteer SET location='$locationEdit' Where id='$idEdit'";
                $resultUpdatelocation=$pdo->exec($queryUpdatelocation);
            }
            if($rowGetInfo['gathering']!="$gatheringEdit"){
                $queryUpdategathering="UPDATE volunteer SET gathering='$gatheringEdit' Where id='$idEdit'";
                $resultUpdategathering=$pdo->exec($queryUpdategathering);
            }
            if($rowGetInfo['group']!="$groupEdit"){
                $queryUpdategroup="UPDATE volunteer SET volunteergroup='$groupEdit' Where id='$idEdit'";
                $resultUpdategroup=$pdo->exec($queryUpdategroup);
            }
    
$pdo=null;
header("location:volunteer.php");
 }catch(PDOException $e){
    if($e->getCode()==23000){
        if (strpos($e->getMessage(), 'date') !== false){
            header("Location: error.php?error=dateWork");
        }
    }
    }

?>