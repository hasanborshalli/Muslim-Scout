<?php

 require_once ("config.php");
 session_start();

 try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!='It')){
        header("Location:logout.php");
        exit;
    }
        if(isset($_POST['idEdit'],$_POST['titleEdit'],$_POST['descriptionEdit'])){
            extract($_POST);
            $queryGetInfo="Select * from news where id='$idEdit' and is_deleted='false'";
            $resultGetInfo=$pdo->query($queryGetInfo);
            $rowGetInfo=$resultGetInfo->fetch();
            if (!empty($_FILES['photoEdit']['name'])){
                $photoEdit = "img/".$_FILES['photoEdit']['name'];
                move_uploaded_file($_FILES['photoEdit']['tmp_name'], $photoEdit);
                
                if($rowGetInfo['photo']!="$photoEdit"){
                    $queryUpdatePhoto="UPDATE news SET photo='$photoEdit' Where id='$idEdit'";
                    $resultUpdatePhoto=$pdo->exec($queryUpdatePhoto);
                }
            }
            
            if($rowGetInfo['title']!="$titleEdit"){
                $queryUpdatetitle="UPDATE news SET title='$titleEdit' Where id='$idEdit'";
                $resultUpdatetitle=$pdo->exec($queryUpdatetitle);
            }
            if($rowGetInfo['description']!="$descriptionEdit"){
                $queryUpdatedescription="UPDATE news SET description='$descriptionEdit' Where id='$idEdit'";
                $resultUpdatedescription=$pdo->exec($queryUpdatedescription);
            }
        }
   
   
$pdo=null;
header("location:it.php");
 }catch(PDOException $e){
    die($e->getMessage());
    }

?>