<?php
require_once ("config.php");
session_start();
try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    if($_SESSION['role']!="Leader"){
      header("location:logout.php");
      exit;
    }
    $currentDateTime = date('Y-m-d');
    $district=$_SESSION['district'];
    $troop=$_SESSION['troop'];
    $groupsession=$_SESSION['group'];
    $queryGetActivities="SELECT title,id FROM activities where is_deleted='false' and is_attended='false' and date = '$currentDateTime' and (district='$district' or district='All') and (troop='$troop' or troop='All') and (gr='$groupsession' or gr='All')";
    $resultGetActivities=$pdo->query($queryGetActivities);
    $rowGetActivities=$resultGetActivities->fetch();
    $rowGetActivitiesCount=$resultGetActivities->rowCount();
    $queryGetScouts="SELECT firstname,lastname,id FROM user WHERE is_deleted='false' and troop='$troop' and usergroup='$groupsession' and role='Scout'";
    $resultGetScouts=$pdo->query($queryGetScouts);
}catch(PDOException $e){
    die($e->getMessage());
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/attendance.css">
    <link rel="icon" href="img/logoo.png">
    <title>Attendance</title>
</head>

<body>
    <?php include "header.php"?>
    <?php
    if($rowGetActivitiesCount>0){
echo"<div class='container'>";
    
echo"<h2 align='center'>Take Attendance for $rowGetActivities[title]</h2>";
        echo<<<EOF
        <table class="myTable" id="myTable">
        <thead>
        <tr class="header">
        <th style="width:5%;">ID</th>
        <th style="width:70%;">Scout Name</th>
        <th style="width:25%;">Attend</th>
        </tr>
        </thead>
        <tbody>
        EOF; 
            
            $count=1;
            while($rowGetScouts=$resultGetScouts->fetch()){
                echo<<<EOF
                <tr>
                <td>$count</td>
                <td>$rowGetScouts[firstname] $rowGetScouts[lastname]</td>
                <td>
                <div id="$rowGetScouts[id]" class="toggle-button" onclick="toggleButton()">
                <div class="switch"></div>
                </div>
                </td>
                </tr>
                EOF;
                $count++;
            }
            
        echo"</tbody>";
        echo"</table>";
        echo"<input type='button' value='Submit Attendance' id='submit-button' onclick='submitAttendance($rowGetActivities[id])'>";
        echo"</div>";
        }else{
            echo<<<EOF
            <div class="noAttendance">
            <img src="img/attendance.png">
            <h2>Oh, hello again! Attendance's been checked off the list. Take a load off and revel in the satisfaction of a job already well done!</h2>
            </div>
            EOF;
        }
        ?>
    <?php include "footer.php"?>
    <script>
    const toggleButtons = document.querySelectorAll('.toggle-button');
    toggleButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            toggleButton(button);
        });
    });


    function toggleButton(button) {
        const switchElement = button.querySelector('.switch');
        const isOn = button.classList.contains('toggle-on');


        if (isOn) {
            button.classList.remove('toggle-on');
        } else {
            button.classList.add('toggle-on');
        }
    }

    function submitAttendance(id) {
        var url = "addattendance.php?activityId=" + id + "&";
        toggleButtons.forEach(function(button) {
            const isOn = button.classList.contains('toggle-on');
            if (isOn) {
                url += "id" + button.id + "=" + button.id + "&";
            }
        });
        window.location.href = url;
    }
    </script>
</body>

</html>