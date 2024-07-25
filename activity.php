<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
 <script type='text/javascript'>
 (function(){emailjs.init('9AC0qXLZ_qBvRJy8Y');
 })();
 </script>
<?php
require_once ("config.php");
session_start();
try{
$pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);

$currentDateTime = date('Y-m-d');
$district=$_SESSION['district'];
$troop=$_SESSION['troop'];
$groupsession=$_SESSION['group'];
$fname=$_SESSION['fname'];
$lname=$_SESSION['lname'];
$id=$_SESSION['id'];
$role=$_SESSION['role'];

if($role=='Scout'||$role=='Leader'){
$queryShowActivities="SELECT * FROM activities where date >= '$currentDateTime' and (district='$district' or district='All') and (troop='$troop' or troop='All') and (gr='$groupsession' or gr='All') and is_deleted='false'";
$result = $pdo->query($queryShowActivities); 

}else if($role=='Troop Leader'){
    $queryShowActivities="SELECT * FROM activities where date >= '$currentDateTime' and (district='$district' or district='All') and (troop='$troop' or troop='All')and is_deleted='false'";
    $result = $pdo->query($queryShowActivities);  

}else if($role=='Commander'){
    $queryShowActivities="SELECT * FROM activities where date >= '$currentDateTime' and (district='$district' or district='All')and is_deleted='false'";
$result = $pdo->query($queryShowActivities);
}

$queryShowRequested="SELECT * FROM requestedactivities where is_deleted='false'";
$resultShowRequested=$pdo->query($queryShowRequested);
$rowShowRequested = $resultShowRequested->fetch();
$row4count=$resultShowRequested->rowcount();

if ($row4count>0){
$idRequested=$rowShowRequested['userId'];
$queryGetInfo="SELECT firstname, lastname, usergroup, email from user where id='$idRequested' and is_deleted='false'";
    $resultGetInfo=$pdo->query($queryGetInfo);
    $rowGetInfoCount=$resultGetInfo->rowCount();
    if($rowGetInfoCount>0){
    $rowGetInfo=$resultGetInfo->fetch();
    $firstname=$rowGetInfo['firstname'];
    $lastname=$rowGetInfo['lastname'];
    $group=$rowGetInfo['usergroup'];
    $email=$rowGetInfo['email'];
 }
}

}catch(PDOException $e){
    die($e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/activity.css">
    <link rel="icon"  href="img/logoo.png">
    <title>Activity Page</title>
</head>
<body>
    <?php include "header.php"?>
    <div class="head-container">
    <h1 id="head">Activities</h1>
    </div>
<div class="table">
    <table class="activity-table">
        <tr>
            <?php
            if($role=="Troop Leader"){
                echo"<td class='hidden' id='first-hidden'>Delete</td>";
                echo"<td class='hidden' id='second-hidden'>Edit</td>";
            }
            ?>
            
            <td>Activity</td>
            <td>Date</td>
            <td>Time</td>
            <td id="desc">Description</td>
            <td>Activity Location</td>
            <td>Gathering Location</td>
        </tr>
        <?php
while($row1 = $result->fetch()){
    if($role=="Troop Leader"){
        echo <<<END
        <div class="registeredUsers" id="registered-$row1[id]">
        <h1>$row1[title]</h1>
        <p>This Activity is for group: $row1[gr]</p>
        END;
    
    echo <<<EOF
    <tr>
    <td class='hidden' onclick="deleteActivity($row1[id],'$row1[title]')">❌</td>
    <td class='hidden' onclick="EditActivity($row1[id],'$row1[title]','$row1[date]','$row1[time]','$row1[description]','$row1[location]','$row1[gathering]','$row1[gr]')">✏️</td>
    <td style="cursor:pointer;" onclick="showRegisteredDiv($row1[id])">$row1[title]</td>
    <td>$row1[date]</td>
    <td>$row1[time]</td>
    <td>$row1[description]</td>
    <td>$row1[location]</td>
    <td>$row1[gathering]</td>
    </tr>
    EOF;
}
else if($role=="Scout"||$role=="Leader"){
    echo <<<EOF
    <tr>
    <td>$row1[title]</td>
    <td>$row1[date]</td>
    <td>$row1[time]</td>
    <td>$row1[description]</td>
    <td>$row1[location]</td>
    <td>$row1[gathering]</td>
    </tr>
    EOF;
}
else if($role=="Commander"){
    echo <<<END
    <div class="registeredUsers" id="registered-$row1[id]">
    <h1>$row1[title]</h1>
    <p>This Activity is for troop: $row1[troop]</p>
    <p>And for group: $row1[gr]</p>
    END;
    echo <<<EOF
    <tr>
    <td  style="cursor:pointer;" onclick="showRegisteredDiv($row1[id])">$row1[title]</td>
    <td>$row1[date]</td>
    <td>$row1[time]</td>
    <td>$row1[description]</td>
    <td>$row1[location]</td>
    <td>$row1[gathering]</td>
    </tr>
    EOF;
}
}
?>
    </table>
</div>

<div id="add-activity" class="add-activity" onclick="addActivityShow()"><p>Add Activity<p></div>
<div class="request-activity" id="request-activity" onclick="requestActivityShow()"><p>Request Activity</p></div>
<div class="requested-activities" id="requested-activities" onclick="requestedActivitiesShow()"><p>Requested Activities</p></div>

<div class="new-activity" id="new-activity">
    <form method="post" action="addactivity.php">
        <h1>Fill in Activity Details</h1>
    <input type="text" name="title" id="title" placeholder="Title" required><br>
    <input type="text" name="description" id="description" placeholder="Description" required><br>
    <input type="date" id="date" name="date"  required><br>
    <input type="time" id="time" name="time"  required><br>
    <input type="text" name="location" id="location" placeholder="Activity Location" required><br>
    <input type="text" name="gathering" placeholder="Gathering Location" required><br>
    

                <select name="group" id="group" required>
                    <option selected disabled>Select Group</option>
                    <option> الأشبال</option>
                    <option>الكشافة</option>
                    <option>الجوال</option>
                </select><br>
   
                <input type="submit" value="Add Activity" id="submit-button" >
    </form>
</div>
<div class="edit-activity" id="edit-activity">
    <form method="post" action="editactivity.php">
        <h1></h1>
    <input type="text" name="titleEdit" id="titleEdit" placeholder="Title" required><br>
    <input type="text" name="descriptionEdit" id="descriptionEdit" placeholder="Description" required><br>
    <input type="date" id="dateEdit" name="dateEdit"  required><br>
    <input type="time" id="timeEdit" name="timeEdit"  required><br>
    <input type="hidden" name="idEdit" id="idEdit">
    <input type="text" name="locationEdit" id="locationEdit" placeholder="Activity Location" required><br>
    <input type="text" name="gatheringEdit" id="gatheringEdit" placeholder="Gathering Location" required><br>
                <select name="groupEdit" id="groupEdit" required>
                    <option selected disabled>Select Group</option>
                    <option> الأشبال</option>
                    <option>الكشافة</option>
                    <option>الجوال</option>
                </select><br>
    <input type="submit" value="Edit Activity" id="submit-button" >
    </form>
</div>
<div class="request-activityBlock" id="request-activityBlock">
    <form method="post" action="requestActivity.php">
        <h1>Fill in Activity Details</h1>
    <input type="text" name="titleRequest" placeholder="Title" required><br>
    <input type="text" name="descriptionRequest" placeholder="Description" required><br>
    <input type="text" name="locationRequest" placeholder="Activity Location" required><br>
    <input type="submit" value="Request Activity" id="submit-button">
    </form>
</div>
<div class="requested-activitiesBlock" id="requested-activitiesBlock">
<h1>Requested Activities</h1>
<table class="requestTable">
    <tr>
        <td>Title</td>
        <td>Description</td>
        <td>Location</td>
        <td>Requested By</td>
        <td>group</td>
        <td>Accept or Reject</td>
    </tr>

    
        <?php
$queryShowRequested2="SELECT * FROM requestedactivities where is_deleted='false'";
$resultShowRequested2=$pdo->query($queryShowRequested2);

while($row4 = $resultShowRequested2->fetch()){
    $queryCheckDistrict="Select district,troop from user where id='$row4[userId]'";
            $resultCheckDistrict=$pdo->query($queryCheckDistrict);
            $rowCheckDistrict=$resultCheckDistrict->fetch();
            if($rowCheckDistrict['district']==$district&&$rowCheckDistrict['troop']==$troop){

   echo <<<EOF
   <tr id='$row4[id]'>
   <td>$row4[title]</td>
   <td>$row4[description]</td>
   <td>$row4[location]</td>
   <td>$firstname $lastname</td>
   <td>$group</td>
   <td>
   <button id='acceptButton' onclick='acceptActivity($row4[id])'>✔️</button>
   <button onclick="rejectActivity($row4[id],'$row4[title]','$firstname','$email')">❌</button>
   </td>
   </tr>
   EOF;
}
}
?>
</table>
</div>
    <?php include "footer.php"?>
    <div class="confirm" id="confirm">
        <p id="confirm-header"></p>
        <div class="buttons">
            <button onclick="decline()">No</button>
            <button id="yes" onclick="window.location.href = 'deleteactivity.php?id=' + yes.id">Yes</button>
            <button id="yes2">Yes</button>

        </div>
    </div>
    <script> 
    const addActivity = document.getElementById("add-activity");
const requestActivity = document.getElementById("request-activity");
const requestedActivities = document.getElementById("requested-activities");

         <?php
        if($_SESSION['role']=='Troop Leader'){
            echo"addActivity.style.display='block';";
            echo"requestedActivities.style.display='block';";

        }
        else if($_SESSION['role']=='Leader' || $_SESSION['role']=='Commander'){
            echo"requestActivity.style.display='block';";
        }
        ?>
    </script> 
        <script src="js/activity.js"></script> 

</body>
</html>