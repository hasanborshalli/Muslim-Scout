<?php
    require_once ("config.php");
    try{
        if(isset($_POST['id'],$_POST['password'])){
            $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
            extract($_POST);
            
            $query="SELECT * FROM user WHERE id='$id' and is_deleted='false'";
            $result = $pdo->query($query);
            $r=$result->rowCount();
            if($r>0){
                    
                $row=$result->fetch();
                   $correctPassword=$row['password'];
                   $salt=$row['user_salt'];
                   $saltedpassword=substr($salt,0,6).$password.substr($salt,6,5);
                   $hashedPassword= hash("sha256",$saltedpassword);
                   
                if($hashedPassword===$correctPassword){
                session_start();
                $_SESSION['loggedin']=true;
                $_SESSION['id']=$id;
                $_SESSION['role']=$row['role'];
                $_SESSION['district']=$row['district'];
                $_SESSION['troop']=$row['troop'];
                $_SESSION['group']=$row['usergroup'];
                $_SESSION['fname']=$row['firstname'];
                $_SESSION['lname']=$row['lastname'];
                $_SESSION['email']=$row['email'];
                $_SESSION['phone']=$row['phone'];
                $_SESSION['gender']=$row['gender'];
                $_SESSION['registerDate']=$row['registerDate'];
                $_SESSION['photo']=$row['photo'];
                $_SESSION['age']=$row['age'];
                $_SESSION['points']=$row['points'];
                if($row['role']=="Scout"){
                    header("location:news.php");}
                else if($row['role']=="Leader"){
                    header("location:news.php");
                }
                else if($row['role']=="Troop Leader"){
                    header("location:news.php");
                }
                else if($row['role']=="Commander"){
                    header("location:news.php");
                }
                else if($row['role']=="Hr"){
                    header("location:hr.php");
                }
                else if($row['role']=="It"){
                    header("location:It.php");
                }
            
            }else{
                $_SESSION['loggedin']=false;
                echo<<<EOF
                <style>
                .warning {
                width: 30%;
                height: 250px;
                background-color: white;
                box-shadow: 0px 15px 25px 0px rgba(0, 0, 0, 0.5);
                z-index: 3;
                position: fixed;
                left: 35%;
                top: 40%;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                font-weight: 700;
                font-size: 20px;
                display:flex;
                }
                .warning button {
                width: 70px;
                }
                </style>
                <div class="warning" id="warning">
                <p>⚠️</p>
                <p>ID or Password are wrong.</p>
                <p> Please try again!</p>
                <button onclick="decline()">Ok</button>
                </div>
                EOF;
                // header("location:login.php");
    
            }
            }
          else{
            $_SESSION['loggedin']=false;
            echo<<<EOF
            <style>
            .warning {
            width: 30%;
            height: 250px;
            background-color: white;
            box-shadow: 0px 15px 25px 0px rgba(0, 0, 0, 0.5);
            z-index: 3;
            position: fixed;
            left: 35%;
            top: 40%;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: 700;
            font-size: 20px;
            display:flex;
            }
            .warning button {
            width: 70px;
            }
            </style>
            <div class="warning" id="warning">
            <p>⚠️</p>
            <p>ID or Password are wrong.</p>
            <p> Please try again!</p>
            <button onclick="decline()">Ok</button>
            </div>
            EOF;
            // header("location:login.php");

        }
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
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon"  href="img/logoo.png">

</head>
<body>
<a href="home.php"><img src="img/logo.jpeg" id="big-logo"></a>
    <img src="img/logoo.png" id="logo">
        <form method="post">
    <div class="container">
    <img src="img/profile.jpeg">
    <ul>
   <li><input type="text" placeholder="ID" name="id"  required></li>
  <li><input type="text" placeholder="Password" name="password"required></li>
</ul>
<input type="submit" value="LOGIN">
    </div>
</form>
<script>
const warning=document.getElementById("warning");
     function showWarning(){
        warning.style.display="flex";
     }
    function decline() {
    warning.style.display = "none";
    window.location.href="login.php";
}
</script>
</body>
</html>