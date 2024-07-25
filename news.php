<?php
require_once ("config.php");
session_start();
try{
  $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
  $queryShowNews= "SELECT * FROM news where is_deleted='false' ORDER BY id DESC";
  $resultShowNews= $pdo->query($queryShowNews);
}catch(PDOException $e){
  die($e->getMessage());
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/news.css">
    <link rel="icon"  href="img/logoo.png">
<title>News</title>
</head>
<body>
    <?php include "header.php"; ?>
<section class="big-container">
 
 <?php 
 $count=0;
 $currentTime=strtotime(date("Y-m-d H:i:s"));
 while($rowShowNews=$resultShowNews->fetch()){
$postedTime=strtotime($rowShowNews['datePosted']);
$timeDiff=$currentTime-$postedTime;
if ($timeDiff < 60) {
  $last_updated = "just now";
}else if($timeDiff<3600){
  $minutes = floor($timeDiff / 60);
  $last_updated = "$minutes minute" . ($minutes > 1 ? "s" : "") . " ago";
}else if($timeDiff<86400){
  $hours = floor($timeDiff / 3600);
  $last_updated = "$hours hour" . ($hours > 1 ? "s" : "") . " ago";
}else{
  $days = floor($timeDiff / 86400);
  $last_updated = "$days day" . ($days > 1 ? "s" : "") . " ago";
}
 echo <<<EOF
    <div class="container">
        <div class="photo">
            <img src="$rowShowNews[photo]">
        </div>
        <div class="description">
            <h1>$rowShowNews[title]</h1>
            <p>$rowShowNews[description]</p>
        </div>
        <div class="time">
        <p>Last Updated: $last_updated</p>
        </div>
    </div>
    EOF;
    $count++;
    if($count>=9){
      break;
    }
 }
    ?>   
    </section>
<?php include "footer.php"; ?>

</body>
</html>