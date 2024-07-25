<?php

 require_once ("config.php");
 session_start();

 try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!='It')){
        header("Location:logout.php");
        exit;
    }
       if(isset($_POST['titleEditBook'],$_POST['linkEditBook'])){
        extract($_POST);
        $queryGetInfo="Select * from library where id='$idEditBook' and is_deleted='false'";
        $resultGetInfo=$pdo->query($queryGetInfo);
        $rowGetInfo=$resultGetInfo->fetch();

       }
            if($rowGetInfo['title']!="$titleEditBook"){
                $queryUpdatetitle="UPDATE library SET title='$titleEditBook' Where id='$idEditBook'";
                $resultUpdatetitle=$pdo->exec($queryUpdatetitle);
            }
            if($rowGetInfo['link']!="$linkEditBook"){
                $queryUpdatelink="UPDATE library SET link='$linkEditBook' Where id='$idEditBook'";
                $resultUpdatelink=$pdo->exec($queryUpdatelink);
            }

$pdo=null;
header("location:it.php");
 }catch(PDOException $e){
    die($e->getMessage());
    }

?>