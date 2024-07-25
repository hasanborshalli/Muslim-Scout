<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
    </script>
<script type='text/javascript'>
 (function(){emailjs.init('P86PHfM4Fi8i4s-5m');
 })();
 </script>
<?php
 require_once ("config.php");
 session_start();
 $hrfname=$_SESSION['fname'];
 $hrlname=$_SESSION['lname'];
 $name="$hrfname $hrlname";
 try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
if(isset($_SESSION['loggedin'])&&($_SESSION['role']=="Hr")){
    
    if(isset($_POST['fname'],$_POST['lname'],$_POST['email'],$_POST['phone'],$_POST['age'],$_POST['gender'],$_POST['district'],$_POST['troop'],$_POST['group'],$_POST['role'],$_POST['password'])){
        
        $currentDateTime = date('Y-m-d H:i:s');   
        extract($_POST);
        
        if (!empty($_FILES['photo']['name'])){
           
        $photo = "img/".$_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
        }
        $salt=bin2hex(random_bytes(6));
        $saltedpassword=substr($salt,0,6).$password.substr($salt,6,5);
        $hashpwd=hash('sha256',$saltedpassword);
        $queryCheck="SELECT * FROM applications where email='$email' and is_deleted='false'";
        $resultCheck=$pdo->query($queryCheck);
        $r=$resultCheck->rowCount();
        if($r>0){
            $rowCheck=$resultCheck->fetch();
            $photo=$rowCheck['image'];
            $queryDelete="UPDATE applications set is_deleted='true' where email='$email'";
            $resultDelete=$pdo->exec($queryDelete);
        }
        if($district==0){
            $district='Beirut';
            
        }
        else if($district==1){
            $district='Bekaa';
        }
        else if($district==2){
            $district='Mount Lebanon';
        }
        else if($district==3){
            $district='South';
        }
        else if($district==4){
            $district='North';
        }
        else if($district==5){
            $district='Hasbaya and Marjayoun';
        }
       
        if($role=="Leader"||$role=="Troop Leader"||$role=="Commander"){
            
            $queryCheckDuplicate="Select * from user where district='$district' and troop='$troop' and usergroup='$group' and role='$role' and is_deleted='false'";
            $resultCheckDuplicate=$pdo->query($queryCheckDuplicate);
            $rowCheckDuplicate=$resultCheckDuplicate->rowCount();
            if($rowCheckDuplicate>0){
                header("location:error.php?error=leader");
            }
            else{
                
                $query="insert into user values('','$fname','$lname','$age','$district','$troop','$group','$role','$email','$gender','$phone','$hashpwd','$salt','$currentDateTime','$photo','50','false')";
                $result=$pdo->exec($query);
                $queryGetId="SELECT id FROM `user` order by id desc limit 1 ";
                $resultGetId=$pdo->query($queryGetId);
                $rowGetId=$resultGetId->fetch();
                $id=$rowGetId['id'];
                ?>
                <script>
                let parms={
                    fname : '<?php echo $fname?>',
                    lname: '<?php echo $lname?>',
                    id : '<?php echo $id?>',
                    password : '<?php echo $password?>',
                    role: '<?php echo $role?>',
                    district: '<?php echo $district?>',
                    troop: '<?php echo $troop?>',
                    group: '<?php echo $group?>',
                    email : '<?php echo $email?>',
                    hrname: '<?php echo $name?>'
                }
                    emailjs.send("service_gm6acjf","template_kezbevr",parms);
                    window.location.href='hr.php';
                    </script>
                <?php
            }
        }
        else if($role=="Scout"){
            
            $query2="insert into user values('','$fname','$lname','$age','$district','$troop','$group','$role','$email','$gender','$phone','$hashpwd','$salt','$currentDateTime','$photo','0','false')";
            $result2=$pdo->exec($query2);
        $queryGetId2="SELECT id FROM `user` order by id desc limit 1 ";
        $resultGetId2=$pdo->query($queryGetId2);
        $rowGetId2=$resultGetId2->fetch();
        $id2=$rowGetId2['id'];
        ?>
                <script>
                let parms2={
                    fname : '<?php echo $fname?>',
                    lname: '<?php echo $lname?>',
                    id : '<?php echo $id2?>',
                    password : '<?php echo $password?>',
                    role: '<?php echo $role?>',
                    district: '<?php echo $district?>',
                    troop: '<?php echo $troop?>',
                    group: '<?php echo $group?>',
                    email : '<?php echo $email?>',
                    hrname: '<?php echo $name?>'
                }
                    emailjs.send("service_gm6acjf","template_kezbevr",parms2);
                    window.location.href='hr.php';
                    </script>
                <?php
    }
}
}else{
    header("Location:logout.php");
    exit;
}
$pdo=null;
 }catch(PDOException $e){
    if($e->getCode()==23000){
        if (strpos($e->getMessage(), 'email') !== false){
            header("Location: error.php?error=email");
        }elseif (strpos($e->getMessage(), 'phone') !== false){
            header("Location: error.php?error=phone");
        }
    }
}
    ?>