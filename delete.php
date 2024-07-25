<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
    </script>
 <script type='text/javascript'>
 (function(){emailjs.init('9AC0qXLZ_qBvRJy8Y');
 })();
 </script>
<?php
session_start();
require_once ("config.php");
try{

if((!isset($_SESSION['loggedin']))||($_SESSION['role']!='Troop Leader')){
  header("Location:logout.php");
  exit;
}
if(isset($_GET['todel'],$_GET['toname'],$_GET['email'])){
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    
    $queryDelete="UPDATE requestedactivities SET is_deleted='true'  WHERE id='".$_GET['todel']."'";
    $resultDelete=$pdo->exec($queryDelete);
    $toname=$_GET['toname'];
    $email=$_GET['email'];
    $firstnameU=$_SESSION['fname'];
    $lastnameU=$_SESSION['lname'];
    $troop=$_SESSION['troop'];
}
}catch(PDOException $e){
  die($e->getMessage());
  }
?>
<script>
  var parms={
    toname: "<?php echo $toname ?>",
    fname: "<?php echo $firstnameU ?>",
    lname: "<?php echo $lastnameU ?>",
    troop: "<?php echo $troop ?>",
    email: "<?php echo $email ?>",
  };
emailjs.send("service_k0hxy7c","template_4f7igpt",parms);
window.location.href="activity.php";
</script>
