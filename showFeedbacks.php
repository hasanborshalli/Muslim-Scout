<?php
session_start();
require_once('config.php');
try{
$pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
if($_SESSION['role']!="Commander"){
    header("location:logout.php");
    exit;
}
$queryShowFeedbacks="SELECT * FROM feedbacks where is_deleted='false'";
$resultShowFeedbacks=$pdo->query($queryShowFeedbacks);

}catch(PDOException $e){
    die($e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/showFeedbacks.css">
    <link rel="icon"  href="img/logoo.png">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
    </script>
 <script type='text/javascript'>
 (function(){emailjs.init('P86PHfM4Fi8i4s-5m');
 })();
 </script>
    <title>Feedbacks</title>
</head>
<body>
<?php include "header.php"?>
<section class="main-container">
<div class="feedbackListBlock">
    <h1>List Of Feedbacks</h1>
    <ol class="feedbackList">
        <?php
    while($rowShowFeedbacks=$resultShowFeedbacks->fetch()){
        echo "<li id='$rowShowFeedbacks[id]' onclick='showFeedback($rowShowFeedbacks[id])'>$rowShowFeedbacks[email]<span>$rowShowFeedbacks[issue]</span><span>$rowShowFeedbacks[email]</span></li>";
    }
        ?>
    </ol>
</div>
<div class="show-feedback">
<h1>Feedback Details</h1>
<ul>
        <li> <label for="email">Email:</label></li>
        <li> <input type="email" id="email" name="email" required></li>       
        <li><label for="issue">Issue:</label></li>
        <li> <textarea rows="5" cols="20" id="issue" name="issue"></textarea></li>
        <li><label for="reply">Your Reply:</label></li>
        <li> <textarea rows="5" cols="20" id="reply" name="reply"></textarea></li>
</ul>
<input type="button" value="Send Reply" id="reply-button" onclick="sendReply()">
</div>
</section>
<?php include "footer.php"?>

<script>
    const message=document.getElementById("reply");
    const email=document.getElementById("email");
    const issue=document.getElementById("issue");
    function showFeedback(id){
        const li=document.getElementById(id);
        const data=li.querySelectorAll("span");
        issue.value=data[0].textContent;
        email.value=data[1].textContent;
    }
    function sendReply(){
    let parms={
        message: message.value,
        fname: "<?php echo "$_SESSION[fname]"; ?>",
        lname: "<?php echo "$_SESSION[lname]"; ?>",
        district: "<?php echo "$_SESSION[district]"; ?>",
        email: email.value,

    };
    emailjs.send("service_gm6acjf","template_1aarf89",parms);
   
        window.location.href="deleteFeedback.php?email="+email.value+" &issue="+issue.value;
        
}
</script>
</body>
</html>