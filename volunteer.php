<?php
require_once ("config.php");
session_start();
$district=$_SESSION['district'];
$troop=$_SESSION['troop'];
$groupsession=$_SESSION['group'];
$fname=$_SESSION['fname'];
$lname=$_SESSION['lname'];
$id=$_SESSION['id'];
$role=$_SESSION['role'];
try{
$pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
$currentDateTime = date('Y-m-d H:i:s');

if($role=='Scout'||$role=='Leader'){
    $queryShowWorks="SELECT * FROM volunteer where date > '$currentDateTime' and (district='$district' or district='All') and (troop='$troop' or troop='All') and (volunteergroup='$groupsession' or volunteergroup='All') and is_deleted='false'";
    $resultShowWorks = $pdo->query($queryShowWorks); 
    
    }else if($role=='Troop Leader'){
        $queryShowWorks="SELECT * FROM volunteer where date > '$currentDateTime' and (district='$district' or district='All') and (troop='$troop' or troop='All')and is_deleted='false'";
        $resultShowWorks = $pdo->query($queryShowWorks);  
    
    }else if($role=='Commander'){
        $queryShowWorks="SELECT * FROM volunteer where date > '$currentDateTime' and (district='$district' or district='All')and is_deleted='false'";
    $resultShowWorks = $pdo->query($queryShowWorks);
    }

$queryGetRegisteredWorks="SELECT * FROM registeredworks where userId='$id'";
$resultGetRegisteredWorks=$pdo->query($queryGetRegisteredWorks);
$rowGetRegisteredWorksCount=$resultGetRegisteredWorks->rowCount();

$queryShowRequested="SELECT * FROM requestedworks where is_deleted='false'";
$resultShowRequested=$pdo->query($queryShowRequested);
$rowShowRequested2=$resultShowRequested->fetch();
$rowShowRequested2Count=$resultShowRequested->rowCount();
if($rowShowRequested2Count>0){
    $idRequested=$rowShowRequested2['userId'];
    $queryGetInfo="SELECT firstname,lastname FROM user WHERE id='$idRequested' and is_deleted='false'";
    $resultGetInfo=$pdo->query($queryGetInfo);
    $rowGetInfoCount=$resultGetInfo->rowCount();
    if($rowGetInfoCount>0){
    $rowGetInfo=$resultGetInfo->fetch();
    $firstname=$rowGetInfo['firstname'];
    $lastname=$rowGetInfo['lastname'];
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
    <link rel="stylesheet" href="css/volunteer.css">
    <link rel="icon"  href="img/logoo.png">
    <!-- this is for fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <!-- this is for fonts -->
<title>Register Volunteer Work</title>
</head>
<body>
<?php include "header.php"?>
    <div class="head-container">
    <h1 id="head">Volunteer Works</h1>
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
            <td>Work Title</td>
            <td>Date</td>
            <td>time</td>
            <td id="desc">Description</td>
            <td>Work Location</td>
            <td>Gathering Location</td>
            <?php
            if($role=="Leader"||$role=="Scout"){
                echo"<td>Register</td>";
            }
            ?>        </tr>
        <?php
        while ($rowShowWorks=$resultShowWorks->fetch()){
            $queryCheckRegistered="SELECT * FROM registeredworks WHERE workId='$rowShowWorks[id]' and userId='$id'";
            $resultCheckRegistered=$pdo->query($queryCheckRegistered);
            $rowCheckRegisteredCount=$resultCheckRegistered->rowCount();
           if($rowCheckRegisteredCount<1){
                if($role=="Troop Leader"){
                    $queryGetWorkRegistrations="Select * from registeredworks WHERE workId='$rowShowWorks[id]'";
                    $resultGetWorkRegistrations=$pdo->query($queryGetWorkRegistrations);
                    echo <<<END
                        <div class="registeredUsers" id="registered-$rowShowWorks[id]">
                        <h1>$rowShowWorks[title]</h1>
                        <p>This Work is for group: $rowShowWorks[volunteergroup]</p>
                        <p>These are the scouts registered:</p>
                        <ol>
                        END;
                        while ($rowGetWorkRegistrations=$resultGetWorkRegistrations->fetch()){
                            $queryGetRegisteredInfo="SELECT firstname,lastname FROM user WHERE id='$rowGetWorkRegistrations[userId]'";
                            $resultGetRegisteredInfo=$pdo->query($queryGetRegisteredInfo);
                            $rowGetRegisteredInfo=$resultGetRegisteredInfo->fetch();
                            echo <<<END
                            <li>$rowGetRegisteredInfo[firstname] $rowGetRegisteredInfo[lastname]</li>
                      
                        END;
                        }
            echo "</ol>";
            echo <<<EOF
            <tr>
            <td class='hidden' onclick="deleteWork($rowShowWorks[id],'$rowShowWorks[title]')">❌</td>
            <td class='hidden'  onclick="EditWork($rowShowWorks[id],'$rowShowWorks[title]','$rowShowWorks[date]','$rowShowWorks[time]','$rowShowWorks[description]','$rowShowWorks[location]','$rowShowWorks[gathering]','$rowShowWorks[volunteergroup]')">✏️</td>
            <td style="cursor:pointer;" onclick="showRegisteredDiv($rowShowWorks[id])">$rowShowWorks[title]</td>
            <td>$rowShowWorks[date]</td>
            <td>$rowShowWorks[time]</td>
            <td id="desc">$rowShowWorks[description]</td>
            <td>$rowShowWorks[location]</td>
            <td>$rowShowWorks[gathering]</td>
            EOF;
                }else if($role=="Commander"){
                    $queryGetWorkRegistrations="Select * from registeredworks WHERE workId='$rowShowWorks[id]'";
                    $resultGetWorkRegistrations=$pdo->query($queryGetWorkRegistrations);
                    echo <<<END
                        <div class="registeredUsers" id="registered-$rowShowWorks[id]">
                        <h1>$rowShowWorks[title]</h1>
                        <p>This work is for troop:$rowShowWorks[troop]</p>
                        <p>And for group: $rowShowWorks[volunteergroup]</p>
                        <p>These are the scouts registered:</p>
                        <ol>
                        END;
                        while ($rowGetWorkRegistrations=$resultGetWorkRegistrations->fetch()){
                            $queryGetRegisteredInfo="SELECT firstname,lastname FROM user WHERE id='$rowGetWorkRegistrations[userId]'";
                            $resultGetRegisteredInfo=$pdo->query($queryGetRegisteredInfo);
                            $rowGetRegisteredInfo=$resultGetRegisteredInfo->fetch();
                            echo <<<END
                            <li>$rowGetRegisteredInfo[firstname] $rowGetRegisteredInfo[lastname]</li>
                      
                        END;
                        }
            echo "</ol>";
            echo <<<EOF
            <tr>
            <td style="cursor:pointer;" onclick="showRegisteredDiv($rowShowWorks[id])">$rowShowWorks[title]</td>
            <td>$rowShowWorks[date]</td>
            <td>$rowShowWorks[time]</td>
            <td id="desc">$rowShowWorks[description]</td>
            <td>$rowShowWorks[location]</td>
            <td>$rowShowWorks[gathering]</td>
            </tr>
            EOF;
                }
                
            else if ($role=="Scout"||$role=="Leader"){
            echo <<<EOF
            <tr>
            <td>$rowShowWorks[title]</td>
            <td>$rowShowWorks[date]</td>
            <td>$rowShowWorks[time]</td>
            <td id="desc">$rowShowWorks[description]</td>
            <td>$rowShowWorks[location]</td>
            <td>$rowShowWorks[gathering]</td>
            <td><button onclick="registerWork($rowShowWorks[id],'$rowShowWorks[title]')">Register</button></td>
            </tr>
            EOF;
            }        
        }
    }
        ?>
        </table>
</div>
<div class="edit-work" id="edit-work">
    <form method="post" action="editwork.php">
        <h1></h1>
    <input type="text" name="titleEdit" id="titleEdit" placeholder="Title" required><br>
    <input type="text" name="descriptionEdit" id="descriptionEdit" placeholder="Description" required><br>
    <input type="date" id="dateEdit" name="dateEdit"  required><br>
    <input type="time" id="timeEdit" name="timeEdit"  required><br>
    <input type="hidden" name="idEdit" id="idEdit">
    <input type="text" name="locationEdit" id="locationEdit" placeholder="Activity Location" required><br>
    <input type="text" name="gatheringEdit" id="gatheringEdit" placeholder="Gathering Location" required><br>
                
                <select name="groupEdit" id="groupEdit"  required>
                    <option selected disabled>Select Group</option>
                    <option> الأشبال</option>
                    <option>الكشافة</option>
                    <option>الجوال</option>
                </select><br>
   
                <input type="submit" value="Edit Work" id="submit-button" >
    </form>
</div>
<div class="head-container">
    <h1 id="head">Registered Volunteer Works</h1>
    </div>
<div class="table">
    <table class="activity-table">
        <tr>
            <td>Work Title</td>
            <td>Date</td>
            <td>time</td>
            <td id="desc">Description</td>
            <td>Work Location</td>
            <td>Gathering Location</td>
            <td>Delete</td>
        </tr>
       <?php
        if($rowGetRegisteredWorksCount>0){
            while($rowGetRegisteredWorks=$resultGetRegisteredWorks->fetch()){
                $queryShowRegisteredWorks="SELECT * FROM volunteer where id = '$rowGetRegisteredWorks[workId]' and is_deleted='false'";
                $resultShowRegisteredWorks=$pdo->query($queryShowRegisteredWorks);
                $rowShowRegisteredWorks=$resultShowRegisteredWorks->fetch();
                $rowShowRegisteredWorksCount=$resultShowRegisteredWorks->rowCount();
                if($rowShowRegisteredWorksCount>0){
                echo <<<EOF
                <tr>
                <td>$rowShowRegisteredWorks[title]</td>
                <td>$rowShowRegisteredWorks[date]</td>
                <td>$rowShowRegisteredWorks[time]</td>
                <td id="desc">$rowShowRegisteredWorks[description]</td>
                <td>$rowShowRegisteredWorks[location]</td>
                <td>$rowShowRegisteredWorks[gathering]</td>
                <td><button onclick="deleteRegisteredWork($rowShowRegisteredWorks[id],'$rowShowRegisteredWorks[title]')">Delete</button></td>
                </tr>
                EOF;
            }
        }
        }
       ?>
        </table>
</div>
<div class="request-work-button" id="request-work-button" onclick="requestWorkShow()"><p>Request Volunteer Work</p></div>
<div class="requested-work-button" id="requested-work-button" onclick="requestedWorkShow()"><p>Requested Volunteer Works</p></div>
<div class="add-work-button" id="add-work-button" onclick="addWorkShow()"><p>Add Volunteer Work</p></div>


<div class="request-workBlock" id="request-workBlock">
    <form method="post" action="requestWork.php">
        <h1>Fill in Volunteer Work Details</h1>
    <input type="text" name="titleWork" placeholder="Title" required><br>
    <input type="text" name="descriptionWork" placeholder="Description" required><br>
    <input type="text" name="locationWork" placeholder="Volunteer Work Location" required><br>

    <input type="submit" value="Request Volunteer Work" id="submit-button">
    </form>
</div>
<div class="requested-WorksBlock" id="requested-WorksBlock">
<h1>Requested Volunteer Works</h1>
<table class="requestTable">
    <tr>
        <td>Title</td>
        <td>Description</td>
        <td>Location</td>
        <td>Requested By</td>
        <td>Add</td>
    </tr>
    <?php
        while($rowShowRequested=$resultShowRequested->fetch()){
            $queryCheckDistrict="Select district,troop from user where id='$rowShowRequested[userId]'";
            $resultCheckDistrict=$pdo->query($queryCheckDistrict);
            $rowCheckDistrict=$resultCheckDistrict->fetch();
            if($rowCheckDistrict['district']==$district&&$rowCheckDistrict['troop']==$troop){
            echo <<<EOF
            <tr id=$rowShowRequested[id]>
            <td>$rowShowRequested[title]</td>
            <td>$rowShowRequested[description]</td>
            <td>$rowShowRequested[location]</td>
            <td>$firstname $lastname</td>
            <td><button onclick='acceptWork($rowShowRequested[id])'>Add Work</button></td>
            </tr>
            EOF;
        }
    }
    ?>
    </table>
</div>
<div class="new-work" id="new-work">
    <form method="post" action="addwork.php">
        <h1>Fill in Volunteer Work Details</h1>
    <input type="text" name="title" id="title" placeholder="Title" required><br>
    <input type="text" name="description" id="description" placeholder="Description" required><br>
    <input type="date" id="date" name="date"  required><br>
    <input type="time" id="time" name="time"  required><br>
    <input type="text" name="location" id="location" placeholder="Activity Location" required><br>
    <input type="text" name="gathering" placeholder="Gathering Location" required><br>
                
                <select name="group" id="group"  required>
                    <option selected disabled>Select Group</option>
                    <option> الأشبال</option>
                    <option>الكشافة</option>
                    <option>الجوال</option>
                </select><br>
   
                <input type="submit" value="Add Work" id="submit-button" >
    </form>
</div>
    <?php include "footer.php"?>
    <div class="confirm" id="confirm">
        <p id="confirm-header"></p>
        <div class="buttons">
            <button onclick="decline()">No</button>
            <button id="yes" onclick="window.location.href='deletework.php?id='+yes.id">Yes</button>
            <button id="yes2" onclick="window.location.href='deleteregisteredwork.php?workId='+yes2.id">Yes</button>
            <button id="yes3" onclick="window.location.href='registerwork.php?id='+yes3.id">Yes</button>

        </div>
    </div>

<script>
const requestWorkButton = document.getElementById("request-work-button");
const requestedWorkButton = document.getElementById("requested-work-button");
const addWorkButton = document.getElementById("add-work-button");
<?php
if($_SESSION['role']=="Commander"){
    echo "requestWorkButton.style.display='block';";
}
if($_SESSION['role']=="Troop Leader"){
    echo "requestedWorkButton.style.display='block';";
    echo "addWorkButton.style.display='block';";
}
?>
</script>
<script src="js/volunteer.js"></script>
</body>
</html>