<?php
 require_once ("config.php");
 try{
 if (isset($_POST['fname'],$_POST['lname'],$_POST['email'],$_POST['phone'],$_POST['date'],$_POST['address'],$_POST['gender'])){
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    extract($_POST);
    $currentDateTime = date('Y-m-d H:i:s');
    if (!empty($_FILES['image']['name']))
{
$img = "img/".$_FILES['image']['name'];
move_uploaded_file($_FILES['image']['tmp_name'], $img);
}
    $query="insert into applications values('','$fname','$lname','$date','$email','$phone','$gender','$currentDateTime','$img','$address','false')";
    $result=$pdo->exec($query);
    $pdo=null;
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
    <title>Register Page</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="icon"  href="img/logoo.png">

</head>
<body>
    <div class="head">
<a href="home.php"><img src="img/logo.jpeg" id="logo"></a>
<h1>The Muslim Scout Of Lebanon</h1>
<div></div>
<div></div>
</div>
<form method="post" enctype='multipart/form-data'>
<div class="info">
    <h1>Application Form</h1>
    <div class="name">
        <ul class="first">
            <li>First Name</li>
            <li><input type="text" class="input-name" name="fname" id="fname" onblur="checkCapitalFirst()" required></li>
            <li id="hidden"></li>
        </ul>
        <ul class="last">
        <li>Last Name</li>
            <li><input type="text" class="input-name" name="lname" id="lname" onblur="checkCapitalLast()" required></li>
        </ul>
    </div>
    <div class="email">
        <ul>
            <li>Email</li>
            <li><input type="email" class="input2" name="email" id="email" required></li>
    </ul>
    </div>
    <div class="phone">
        <ul>
            <li>Phone Number</li>
            <li><input type="tel" class="input2" name="phone" id="phone" required></li>
    </ul>
    </div>
    <div class="address">
        <ul>
            <li>Address</li>
            <li><input type="text" class="input2" name="address" id="address" required></li>
    </ul>
    </div>
    <div class="name">
        <ul>
            <li>Date Of Birth</li>
            <li><input type="date" class="input-name" name="date" id="date" required min="2007-01-01" max="2020-12-31"></li>
        </ul>
        <ul>
        <li>Upload Your Photo</li>
            <li><input type="file" class="input-photo" name="image" id="image" required></li>
        </ul>
    </div>
    <div class="gender">
       <span id="gender"> Gender: <span><input type="radio" name="gender" value="male" id="male" required> <label for="male">Male</label>
                <input type="radio" name="gender" value="female" id="female" required> <label for="female">Female</label><br>
                </div>
                <input type="submit" class="submit-button" value="Apply"><br>
                <input type="checkbox" id="terms" required>
        <label for="terms" style="color:#59188C;">I agree to the <a href="terms.php" target="_blank">terms and conditions<a></label>

</div>
</form>
<script>
    const fname=document.getElementById("fname");
    const lname=document.getElementById("lname");
    function capitalizeFirstLetter(input) {
    return input.charAt(0).toUpperCase() + input.slice(1);
}
fname.addEventListener("blur", function (event) {
    const input = event.target;
    input.value = capitalizeFirstLetter(input.value);
});
lname.addEventListener("blur", function (event) {
    const input = event.target;
    input.value = capitalizeFirstLetter(input.value);
});
</script>
</body>