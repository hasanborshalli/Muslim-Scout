<?php

 require_once ("config.php");
 session_start();

 try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    if(isset($_SESSION['loggedin'])&&($_SESSION['role']=="It")){
        $currentDateTime = date('Y-m-d H:i:s');

        if(isset($_POST['titlebook'],$_POST['link'])){
            extract($_POST);
            $queryAddBook="INSERT INTO library values('','$titlebook','$link','0','0','0','false')";
            $resultAddBook=$pdo->exec($queryAddBook);
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