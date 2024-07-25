<?php
require_once ("config.php");
$pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
try{
if(isset($_POST['issue'],$_POST['email'])){
    extract($_POST);
    $queryAddFeedback="insert into feedbacks values('','$email','$issue','false')";
    $resultAddFeedback=$pdo->exec($queryAddFeedback);


}
$pdo=null;

}catch(PDOException $e){
    die($e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="icon"  href="img/logoo.png">
    <link rel="stylesheet" href="css/feedback.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>
<body>
<a href="home.php"> <img src="img/logo.jpeg"></a>
    <h1>Hi 👋</h1>
    <h1>How can we help you?</h1>
    <form method="post">
    <div class="feedback">
        <h3>Report issue!</h3>
        <ul>
        <li><label for="issue">Describe the issue</label></li>
        <li> <textarea rows="5" cols="20" id="issue" name="issue"></textarea></li>
        <li> <label for="email">Email</label></li>
        <li> <input type="email" id="email" name="email" required></li>
        <li><input type="submit" value="Send feecback" ></li>
</ul>

    </div>
</form>
</body>
</html>