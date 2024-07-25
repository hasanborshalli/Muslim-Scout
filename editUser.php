<script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
</script>
<script type="text/javascript">
   (function(){
      emailjs.init({
        publicKey: "Be58OPheqhu3TELyx",
      });
   })();
</script>

<?php

 require_once ("config.php");
 session_start();

 try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    if((!isset($_SESSION['loggedin']))||($_SESSION['role']!='Hr')){
        header("Location:logout.php");
        exit;
    }
     if(isset($_POST['fnameEdit'],$_POST['lnameEdit'],$_POST['emailEdit'],$_POST['phoneEdit'],$_POST['ageEdit'],$_POST['genderEdit'],$_POST['districtEdit'],$_POST['troopEdit'],$_POST['groupEdit'],$_POST['roleEdit'])){
        extract($_POST);
        $queryGetInfo="Select * from user where id='$idEdit' and is_deleted='false'";
        $resultGetInfo=$pdo->query($queryGetInfo);
        $rowGetInfo=$resultGetInfo->fetch();
        if($districtEdit==0){
            $districtEdit='Beirut';
        }
        else if($districtEdit==1){
            $districtEdit='Bekaa';
        }
        else if($districtEdit==2){
            $districtEdit='Mount Lebanon';
        }
        else if($districtEdit==3){
            $districtEdit='South';
        }
        else if($districtEdit==4){
            $districtEdit='North';
        }
        else if($districtEdit==5){
            $districtEdit='Hasbaya and Marjayoun';
        }
        if($rowGetInfo['firstname']!="$fnameEdit"){
            
            $queryUpdatefirstname="UPDATE user SET firstname='$fnameEdit' where id='$idEdit'";
            $resultUpdatefirstname=$pdo->exec($queryUpdatefirstname);
        }
        if($rowGetInfo['lastname']!="$lnameEdit"){
            $queryUpdatelastname="UPDATE user SET lastname='$lnameEdit' where id='$idEdit'";
            $resultUpdatelastname=$pdo->exec($queryUpdatelastname);
        }
        if($rowGetInfo['email']!="$emailEdit"){
            $queryUpdateemail="UPDATE user SET email='$emailEdit' where id='$idEdit'";
            $resultUpdateemail=$pdo->exec($queryUpdateemail);
        }
        if($rowGetInfo['phone']!="$phoneEdit"){
            echo"$phoneEdit";
            $queryUpdatephone="UPDATE user SET phone='$phoneEdit' where id='$idEdit'";
            $resultUpdatephone=$pdo->exec($queryUpdatephone);
        }
        if($rowGetInfo['age']!="$ageEdit"){
            $queryUpdateage="UPDATE user SET age='$ageEdit' where id='$idEdit'";
            $resultUpdateage=$pdo->exec($queryUpdateage);
        }
        if($rowGetInfo['gender']!="$genderEdit"){
            $queryUpdategender="UPDATE user SET gender='$genderEdit' where id='$idEdit'";
            $resultUpdategender=$pdo->exec($queryUpdategender);
        }
        if($rowGetInfo['district']!="$districtEdit"){
            $queryUpdatedistrict="UPDATE user SET district='$districtEdit' where id='$idEdit'";
            $resultUpdatedistrict=$pdo->exec($queryUpdatedistrict);
        }
        if($rowGetInfo['troop']!="$troopEdit"){
            $queryUpdatetroop="UPDATE user SET troop='$troopEdit' where id='$idEdit'";
            $resultUpdatetroop=$pdo->exec($queryUpdatetroop);
        }
        if($rowGetInfo['usergroup']!="$groupEdit"){
            $queryUpdategroup="UPDATE user SET usergroup='$groupEdit' where id='$idEdit'";
            $resultUpdategroup=$pdo->exec($queryUpdategroup);
        }
        
        if (!empty($_FILES['photoEdit']['name'])){
            $photoEdit = "img/".$_FILES['photoEdit']['name'];
            move_uploaded_file($_FILES['photoEdit']['tmp_name'], $photoEdit);

            if($rowGetInfo['photo']!="$photoEdit"){
                $queryUpdatePhoto="UPDATE user SET photo='$photoEdit' Where id='$idEdit'";
                $resultUpdatePhoto=$pdo->exec($queryUpdatePhoto);
            }
        }
        if($rowGetInfo['role']!="$roleEdit"){
            if($roleEdit=="Leader"||$roleEdit=="Troop Leader"||$roleEdit=="Commander"){
                $queryCheckDuplicate="Select * from user where district='$districtEdit' and troop='$troopEdit' and usergroup='$groupEdit' and role='$roleEdit' and is_deleted='false'";
                $resultCheckDuplicate=$pdo->query($queryCheckDuplicate);
                $rowCheckDuplicate=$resultCheckDuplicate->rowCount();
                if($rowCheckDuplicate>0){
                    header("location:error.php?error=leader");
                }else{
            $queryUpdaterole="UPDATE user SET role='$roleEdit' where id='$idEdit'";
            $resultUpdaterole=$pdo->exec($queryUpdaterole);

            $queryGetUser="SELECT firstname,lastname,email from user where id='$idEdit'";
            $resultGetUser=$pdo->query($queryGetUser);
            $rowGetUser=$resultGetUser->fetch();
            echo<<<EOF
                    <script>
                    let parms={
                        toname:'$rowGetUser[firstname] $rowGetUser[lastname]',
                        newrole:'$roleEdit',
                        email:'$rowGetUser[email]',
                    }
                    emailjs.send("service_okbkzsa","template_byj5vnt",parms);
                    window.location.href='hr.php';
                    </script>
            EOF;
                }
        }
    }
     }

  
$pdo=null;
 }catch(PDOException $e){
    die($e->getMessage());
    }

?>
<script>
    window.location.href='hr.php';
</script>