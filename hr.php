<?php

 require_once ("config.php");
 session_start();

 try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    if(isset($_SESSION['loggedin'])&&($_SESSION['role']=="Hr")){
     $currentDateTime = date('Y-m-d H:i:s');

    $query="SELECT * FROM applications where is_deleted='false'";
    $result1=$pdo->query($query);
    
    $queryShowUsers="SELECT * FROM user where is_deleted='false'";
    $result2=$pdo->query($queryShowUsers);

    $resultGetUsers=$pdo->query($queryShowUsers);
    }
else{
    header("Location:logout.php");
    exit;
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
    <link rel="stylesheet" href="css/hr.css">
    <link rel="icon"  href="img/logoo.png">
    <title>Hr Dashboard</title>

</head>
<body>
   <h4>HR Dashboard</h4>
   <div class="main">
   <section class="container">
   
   <input type="button" class="left-buttons" value="🙎🏻‍♂️ Applications" onclick="appformshow()">
    <input type="button" class="left-buttons" value="➕ Add User" onclick="addformshow()">
    <input type="button" class="left-buttons" value="🛠  Edit User" onclick="editformshow()">
    <input type="button" class="left-buttons" value="❌  Delete User" onclick="deleteformshow()">
    <input type="button" class="left-buttons" value="↩  Logout" onclick="window.location.href='logout.php'">
   
   </section>
   <div class="adduser">
    <div class="header" id="header">
        <p>Application Forms</p>
        
    </div>
    
<form method="post" id="appform">
  <ol class="applist">
    <?php

    while($row=$result1->fetch()){
        echo "<li id='$row[id]' onclick='addThis($row[id])'>$row[fname] $row[lname]<span>$row[email]</span><span>$row[phone]</span><span>$row[date]</span><span>$row[gender]</span><span>$row[fname]</span><span>$row[lname]</span><span>$row[image]</span><span>$row[address]</span></li>";
    }
    ?>
  </ol>
</form>
<form method="post" class="adduserform" id="adduserform" enctype='multipart/form-data' action="addUser.php">
    <div class="info">
        <ul>
            <li><img src="" id="photo2"></li>
            <li><input type="text" required placeholder="First Name" id="fname" name="fname" ><input type="text" placeholder="Last Name" name="lname" id="lname" ></li>
            <li><input type="email" required placeholder="Email" name="email" id="email"><input type="tel" placeholder="Phone number" name="phone" id="phone" onblur="checkphone()"></li>
            <li style="display:flex"><input type="hidden" placeholder="Password" id="password" name="password" readonly><input type="file" name="photo" id="photo"><input type="text" id="address" readonly></li>
            <li><input type="date" min="2007-01-01" max="2020-12-31" required  name="age" id="age"><span style="color:white;">Gender:</span> <input type="radio" class="gender-radio" name="gender" id="male" value="male"><label for="male" class="gender-label">Male</label><input type="radio" class="gender-radio" name="gender" id="female" value="female"><label for="female" class="gender-label">Female</label></li>
            <li>
            <select name="role" id="role" onchange="updateOption('district','troop','group','role')" required>
                    <option selected disabled>Select Role</option>
                    <option>Scout</option>
                    <option>Leader</option>
                    <option>Troop Leader</option>
                    <option>Commander</option>
                    <option>Hr</option>
                    <option>It</option>
                </select>

                <select name="district" id="district" required onchange="fillTroop('district','troop')">
                    <option selected disabled value="-1">Select District</option>
                    <option value="0">Beirut</option>
                    <option value="1">Bekaa</option>
                    <option value="2">Mount Lebanon</option>
                    <option value="3">South</option>
                    <option value="4">North</option>
                    <option value="5">Hasbaya and Marjayoun</option>
                </select>

                

            </li>

            <li>
            <select name="troop" id="troop" required>
                    <option selected disabled>Select Troop</option>
                </select>

            <select name="group" id="group" required>
                    <option selected disabled>Select Group</option>
                    <option> الأشبال</option>
                    <option>الكشافة</option>
                    <option>الجوال</option>
                </select>
            </li>
        </ul>
        </form>
        <input type="submit" value="Submit" id="submit-button">
    </div>

    <form class="edituserform" id="edituserform" >
    <select id="district-filter" onchange="filter()">
                    <option selected disabled value="-1">Select District</option>
                    <option value="0">Beirut</option>
                    <option value="1">Bekaa</option>
                    <option value="2">Mount Lebanon</option>
                    <option value="3">South</option>
                    <option value="4">North</option>
                    <option value="5">Hasbaya and Marjayoun</option>
                    <option value="6">All</option>
                </select>
                <select id="troop-filter" onchange="filter()">
                    <option selected disabled>Select Troop</option>
                </select>
                <select id="group-filter" onchange="filter()">
                    <option selected disabled>Select Group</option>
                    <option> الأشبال</option>
                    <option>الكشافة</option>
                    <option>الجوال</option>
                    <option>All</option>
                </select>
                <input type="text" placeholder="Enter to search...   🔍" id="search" onkeyup="searchUser()">
        <ol class="applist">
        <?php
        
        while($row2=$result2->fetch()){
             
           echo "<li id='$row2[id]' onclick='startEdit(`$row2[firstname]`, `$row2[lastname]`,$row2[id],`$row2[email]`,`$row2[phone]`,`$row2[age]`,`$row2[gender]`,`$row2[photo]`,`$row2[points]`,`$row2[registerDate]`)'>$row2[firstname] $row2[lastname]<span>$row2[district]</span><span>$row2[troop]</span><span>$row2[usergroup]</span><span>$row2[role]</span></li>";
            
        }
        ?>
        </ol>
        </form>
        <form id="deleteuserform">
        <ol>
            
        <?php
        
        while($rowGetUsers=$resultGetUsers->fetch()){
            echo <<<EOF
            <li><div class='mainLi'><div class='book-title'>$rowGetUsers[firstname] $rowGetUsers[lastname]</div><span onclick="deleteUser($rowGetUsers[id],'$rowGetUsers[firstname]','$rowGetUsers[lastname]')">❌</span></div></li>
        EOF;
        }
        ?>
           
        </ol>
    </form>
        <form method="post" class="starteditform" id="starteditform" enctype='multipart/form-data' action="editUser.php">
    <div class="info">
        <ul>
            <li id="imgpoints"><img src="" id="photo2Edit"><div class="points">
                <p></p>
                <p></p>
                <p></p>
            </div></li>
            <li><input type="text" required placeholder="First Name" id="fnameEdit" name="fnameEdit" onblur="checkCapitalFirst()"><input type="text" placeholder="Last Name" name="lnameEdit" id="lnameEdit" onblur="checkCapitalLast()"></li>
            <li><input type="email" required placeholder="Email" name="emailEdit" id="emailEdit"><input type="tel" placeholder="Phone number" name="phoneEdit" id="phoneEdit" onblur="checkphone()"></li>
            <li style="display:flex"><input type="file" name="photoEdit" id="photoEdit"><input type="hidden" name="idEdit" id="idEdit"></li>
            <li><input type="date"  required  name="ageEdit" id="ageEdit"><span style="color:white;">Gender:</span> <input type="radio" class="gender-radio" name="genderEdit" id="maleEdit" value="male"><label for="maleEdit" class="gender-label">Male</label><input type="radio" class="gender-radio" name="genderEdit" id="femaleEdit" value="female"><label for="femaleEdit" class="gender-label">Female</label></li>
            <li>
                <select name="districtEdit" id="districtEdit" required onchange="fillTroop('districtEdit','troopEdit')">
                    <option selected disabled value="-1">Select District</option>
                    <option value="0">Beirut</option>
                    <option value="1">Bekaa</option>
                    <option value="2">Mount Lebanon</option>
                    <option value="3">South</option>
                    <option value="4">North</option>
                    <option value="5">Hasbaya and Marjayoun</option>
                    <option>All</option>
                </select>

                <select name="troopEdit" id="troopEdit" required>
                    <option selected disabled>Select Troop</option>
                    <option>All</option>
                </select>

            </li>

            <li>

            <select name="groupEdit" id="groupEdit" required>
                    <option selected disabled>Select Group</option>
                    <option> الأشبال</option>
                    <option>الكشافة</option>
                    <option>الجوال</option>
                    <option>All</option>
                </select>

                <select name="roleEdit" id="roleEdit" onchange="updateOption('districtEdit','troopEdit','groupEdit','roleEdit')" required>
                    <option selected disabled>Select Role</option>
                    <option>Scout</option>
                    <option>Leader</option>
                    <option>Troop Leader</option>
                    <option>Commander</option>
                    <option>Hr</option>
                    <option>It</option>
                </select>

            </li>
        </ul>
        <input type="submit" value="Submit" id="submit-button">
        </form>
    </div>
    <div class="confirm" id="confirm">
        <p id="confirm-header"></p>
        <div class="buttons">
            <button onclick="decline()">No</button>
            <button id="yes" onclick="accept()">Yes</button>
    </div>
    </div>
   <script src="js/hr.js"></script>
</body>
</html>