<?php
require_once ("config.php");
session_start();
try{
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!='Leader')){
        header("Location:logout.php");
        exit;
      }
$pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
foreach ($_GET as $key => $value) {
    if($key!="activityId"){
    $queryUpdatePoints="Update user set points=points+1 where  id='$value'";
    $resultUpdatePoints=$pdo->exec($queryUpdatePoints);
    }
}
$activityId=$_GET['activityId'];
$queryUpdateAttended="update activities set is_attended='true' where id='$activityId'";
$resultUpdateAttended=$pdo->exec($queryUpdateAttended);
header("location:attendance.php");
}catch(PDOException $e){
    die($e->getMessage());

}
    

?>
