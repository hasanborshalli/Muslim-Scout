<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
    </script>
 <script type='text/javascript'>
 (function(){emailjs.init('9AC0qXLZ_qBvRJy8Y');
 })();
 </script>
<?php
require_once ("config.php");
session_start();
try{
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!='Troop Leader')){
        header("Location:logout.php");
        exit;
      }
$pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $fname=$_SESSION['fname'];
    $lname=$_SESSION['lname'];
    $troop=$_SESSION['troop'];
    $district=$_SESSION['district'];
if(isset($_POST['title'],$_POST['description'],$_POST['date'],$_POST['time'],$_POST['location'],$_POST['gathering'],$_POST['group'])){
    extract($_POST);
     $queryCheckDate="Select * from activities where date='$date' and district='$district' and troop='$troop' and gr='$group' and is_deleted='false'";
     $resultCheckDate=$pdo->query($queryCheckDate);
     $rowCheckDateCount=$resultCheckDate->rowCount();
     if($rowCheckDateCount>0){
        header("Location: error.php?error=date");
     }else{


    $queryAddActivities="insert into activities values('$title','$description','$date','$time','$location','$gathering','$district','$troop','$group','','false','false')";
    $result2=$pdo->exec($queryAddActivities);

    $queryGetLeaderInfo="SELECT firstname,lastname,email,id FROM `user` WHERE usergroup='$group' and troop='$_SESSION[troop]' and role='Leader' ";
    $resultGetLeaderInfo=$pdo->query($queryGetLeaderInfo);
    
 
    $rowGetLeaderInfoCount=$resultGetLeaderInfo->rowCount();
    if($rowGetLeaderInfoCount>0){
        $rowGetLeaderInfo=$resultGetLeaderInfo->fetch();
        $leaderName=$rowGetLeaderInfo['firstname']." ".$rowGetLeaderInfo['lastname'];
        $leaderEmail=$rowGetLeaderInfo['email']; 
        $leaderId=$rowGetLeaderInfo['id'];
        
    }
    $queryDeleteRequest="UPDATE requestedactivities SET is_deleted='true' WHERE title='$title' AND userId='$leaderId'";
    $resultDeleteRequest=$pdo->exec($queryDeleteRequest);
    echo<<<EOF
    <script>
    let parms={
        leaderName: '$leaderName',
        date: '$date',
        time: '$time',
        gathering: '$gathering',
        firstname: '$fname',
        lastname: '$lname',
        troop: '$troop',
        leaderEmail: '$leaderEmail',
    }
    emailjs.send("service_k0hxy7c","template_xepnxta",parms);
    window.location.href='activity.php';
    </script>
    EOF;
}
}
}catch(PDOException $e){
    die($e->getMessage());
    }
    ?>