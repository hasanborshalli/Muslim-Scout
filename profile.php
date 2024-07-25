<?php
session_start();
require_once('config.php');
try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $currentDateTime = new DateTime();
    $id=$_SESSION['id'];
    $fname=$_SESSION['fname'];
    $lname=$_SESSION['lname'];
    $district=$_SESSION['district'];
    $troop=$_SESSION['troop'];
    $group=$_SESSION['group'];
    $role=$_SESSION['role'];
    $email=$_SESSION['email'];
    $phone=$_SESSION['phone'];
    $gender=$_SESSION['gender'];
    $photo=$_SESSION['photo'];
    $registerDate=$_SESSION['registerDate'];
    $age=$_SESSION['age'];
    $points=$_SESSION['points'];
    $ageDateTime=new DateTime($age);
    $calculateAge=$currentDateTime->diff($ageDateTime)->y;
    
}catch(PDOException $e){
    die($e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="icon"  href="img/logoo.png">
    <title>Profile</title>
</head>
<body>
    <?php include "header.php"; ?>
    <main>
        <section class="left">
            <div class="first">
                <?php echo"<div class='pic'><img src='$photo'></div>";?>
                <div class="name">
                   <?php echo" <p style='font-weight: 900;'>$fname $lname</p>";
                    echo"<p>$id</p>";
                    ?>
                </div>
            </div>
            <div class="second">
               <?php echo"<p>Joined since $registerDate</p>";
                echo"<p>points: $points</p>"
                ?>
                <p>Medals: <?php
                if($role=="Scout"){
                    if($points>=10){
                        echo"🎗️";
                    }
                    if($points>=20){
                        echo"🏅";
                    }
                    if($points>=30){
                        echo"🥇";
                    }
                    if($points>=40){
                        echo"🥉";
                    }
                    if($points>=50){
                        echo"🎖️";
                    }
                }else if($role=="Leader"){
                    echo"🎗️🏅🥇🥉🎖️🏵️";
                }else if($role=="Troop Leader"){
                    echo"🎗️🏅🥇🥉🎖️🏵️🛡️";
                }else if($role=="Commander"){
                    echo"🎗️🏅🥇🥉🎖️🏵️🛡️⚜️";
                }
                ?></p>
            </div>
        </section>
        <section class="right">
            <h3>General Info</h3>
            <div class="info1">
                <?php
                echo"<p>Age: $calculateAge</p>";
                echo"<p>District: $district</p>";
                echo" <p>Troop: $troop</p>";
                echo" <p>Group: $group</p>";
                echo" <p>Role: $role</p>";
                ?>
            </div>
            <div class="info2">
                <?php
                echo"<p>Email: $email</p>";
                echo"<p>Phone Number: $phone</p>";
                echo"<p>Gender: $gender</p>";
                ?>
            </div>
            <div class="change">
                <input type="button" value="Change Password" class="passbutton" onclick="changeFormShow()"><?php 
                    if(isset($_GET['err'])){
                        if($_GET['err'] == "false"){
                            echo "<p style='color: red'>The Old Pasword Entered is Wrong</p>";
                        }
                    }
                    ?>
            </div>
            <div class="change-form" id="change-form">
                <h1 align="center">Change Password</h1>
                <form action="changepassword.php" method="post">
                    <input type="text" placeholder="Old Password" name="oldpassword"><br><br>
                    <input type="text" placeholder="New Password" name="newpassword"><br><br>
                    <input type="submit" value="Change">
                </form>
            </div>
        </section>
    </main>
    <?php include "footer.php"; ?>
<script>
const changeForm=document.getElementById('change-form');
function changeFormShow(){
if(changeForm.style.display=='block'){
    changeForm.style.display="none";
}else{
    changeForm.style.display="block";
}
}
</script>
</body>
</html>