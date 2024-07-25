
<?php
require_once ("config.php");
try{
$pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);

if((!isset($_SESSION['loggedin']))||($_SESSION['role']=="Hr")||($_SESSION['role']=="It")){
  $_SESSION['loggedin']='false';
  header("Location:logout.php");
  exit;
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
    <link rel="stylesheet" href="css/header.css">
    <link rel="icon"  href="img/logoo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></head>
<body>
    <nav class="navbar">
        <input type="checkbox" id="check">
        <label for="check">
            <i class="fa fa-align-justify" id="btn"></i>
            <i class="fa fa-close" id="cancel"></i>
        </label>
        <div class="logo">
            <img src="img/whitelogo - copy.png">
            <p>The Muslim Scout Of Lebanon</p>
        </div>
        
            <ul>
          <li> <a href="news.php">News</a></li>
          <?php 
          if($_SESSION['role'] == 'Commander'){
            echo "<li> <a href='showFeedbacks.php'>Feedbacks</a></li>";
          }else if($_SESSION['role'] == 'Leader'){
            echo "<li> <a href='attendance.php'>Attendance</a></li>";

          }
          if($_SESSION['role'] == 'Commander' || $_SESSION['role'] == 'Troop Leader' || $_SESSION['role'] == 'Leader'){
            echo "<li> <a href='members.php'>Members</a></li>";
          }
          ?>
          <li> <a href="activity.php">Upcoming Activities</a></li>
          <li> <a href="volunteer.php">Volunteer Work</a></li>
          <li><a href="library.php">Library</a></li>
          <li> <a href="profile.php">Profile</a></li>
          <li> <a href="logout.php">Logout</a> </li>
           </ul>
        
</nav>
</body>
</html>
