<?php
require_once ("config.php");
session_start();
$userId=$_SESSION['id'];
$bookId=$_GET["bookId"];
$stars=$_GET["stars"];
$review=$_GET["review"];
try{
    if(!isset($_SESSION['loggedin'])){
        header("Location:login.php");
        exit;
      }
      $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $queryCheck="SELECT * FROM rated where userId='$userId' and bookId='$bookId'";
      $resultCheck=$pdo->query($queryCheck);
      $rowCheckCount= $resultCheck->rowCount();
      if($rowCheckCount>0){
          $queryAddRated="Update rated set rate='$stars',review='$review' where userId='$userId' and bookId='$bookId'";
      }else{
      $queryAddRated="insert into rated values('$userId','$bookId','$stars','$review')";
      }
      $resultAddRated=$pdo->exec($queryAddRated);
$queryGetnbrates="SELECT * FROM rated where bookId='$bookId'";
$resultGetnbrates=$pdo->query($queryGetnbrates);
$newnbrates=$resultGetnbrates->rowCount();
$newrate=0;
while($rowGetnbrates=$resultGetnbrates->fetch()){
$newrate=$newrate+$rowGetnbrates['rate'];
}
$averageRate=$newrate/$newnbrates;
$queryUpdateRow="update library set rate='$newrate',nbrates='$newnbrates',averageRate='$averageRate' where id='$bookId'";
$resultUpdateRow=$pdo->exec($queryUpdateRow);
header("location:library.php");
    }catch(PDOException $e){
        die($e->getMessage());
        }
?>