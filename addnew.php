<?php

 require_once ("config.php");
 session_start();

 try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    if(isset($_SESSION['loggedin'])&&($_SESSION['role']=="It")){
        $currentDateTime = date('Y-m-d H:i:s');
        
        if(isset($_FILES['photo'],$_POST['title'],$_POST['description'])){
            extract($_POST);


            if (!empty($_FILES['photo']['name']))
            {
            $img = "img/".$_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'], $img);
            }
            $queryAddNew="INSERT INTO news values('','$img','$title','$description','$currentDateTime','false')";
            $resultAddNew=$pdo->exec($queryAddNew);
        }
    }else{
        header("Location:logout.php");
        exit;
    }
        $pdo=null;
header("Location:it.php");
 }catch(PDOException $e){
    die($e->getMessage());
    }
    ?>