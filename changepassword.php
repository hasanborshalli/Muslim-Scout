<?php
require_once("config.php");
session_start();
if((!isset($_SESSION['loggedin']))){
    header("Location:logout.php");
    exit;
  }
if(isset($_POST['oldpassword'],$_POST['newpassword'])){
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    extract($_POST);
    $queryCheckOld="SELECT password, user_salt from user where id='$_SESSION[id]'";
    $resultCheckOld=$pdo->query($queryCheckOld);
    $rowCheckOld=$resultCheckOld->fetch();
    $correctPassword=$rowCheckOld['password'];
    $salt=$rowCheckOld['user_salt'];
    $oldpasswordsalted=substr($salt,0,6).$oldpassword.substr($salt,6,5);
    $hashedPassword= hash("sha256",$oldpasswordsalted);
    
    if($hashedPassword==$correctPassword){
        $newpasswordsalted=substr($salt,0,6).$newpassword.substr($salt,6,5);
        $newhashedPassword= hash("sha256",$newpasswordsalted);
        $queryUpdatePassword="Update user set password='$newhashedPassword' where id='$_SESSION[id]'";
        $resultUpdatePassword=$pdo->exec($queryUpdatePassword);
        
    }else{
     
        header("Location:profile.php?err=false");
        exit();
    }
    header("Location:profile.php");

}else{
    header("Location:logout.php");
    exit;
}
?>