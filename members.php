<?php
require_once ("config.php");
session_start();
$district=$_SESSION["district"];
$troop=$_SESSION["troop"];
$group=$_SESSION["group"];
try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    // if($_SESSION['role']!="Leader"){
    //   header("location:logout.php");
    //   exit;
    // }
    if($_SESSION['role']=="Leader"){
        $queryGetMembers="SELECT firstname, lastname, email, points, registerDate, district, troop, usergroup, role FROM user where district= '$district' and troop= '$troop' and usergroup='$group' and is_deleted='false'";
    }else if($_SESSION['role'] == 'Troop Leader'){
        $queryGetMembers="SELECT firstname, lastname, email, points, registerDate, district, troop, usergroup, role FROM user where district= '$district' and troop= '$troop' and is_deleted='false'";
    }else if($_SESSION['role'] == 'Commander'){
        $queryGetMembers="SELECT firstname, lastname, email, points, registerDate, district, troop, usergroup, role FROM user where district= '$district' and is_deleted='false'";
    }
    $resultGetMembers=$pdo->query($queryGetMembers);

}catch(PDOException $e){
    die($e->getMessage());
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members</title>
    <link rel="icon"  href="img/logoo.png">
<link rel="stylesheet" href="css/members.css">
</head>
<body>
<?php include "header.php"?>

<div class="container">
    <h2 align="center">Members</h2>
    <?php
    if($_SESSION['role'] == 'Troop Leader'|| $_SESSION['role'] =='Commander'){
    echo <<<END
    <select id="group-filter" onchange="filter()">
    <option selected disabled>Select Group</option>
    <option> الأشبال</option>
    <option>الكشافة</option>
    <option>الجوال</option>
    <option>All</option>
    </select>
    END;
    }
    if($_SESSION['role'] == 'Commander') {
        if($_SESSION['district'] == 'Beirut') {
            echo<<<END
            <select id="troop-filter" onchange="filterTroop()">
            <option selected disabled>Select Troop</option>
            <option>Al Iman, Zarif</option>
            <option>Al Hassan Bin Ali, Aramoun</option>
            <option>Ali Ben Abi Taleb, Mar Elias</option>
            <option>Al Markaz Al Isleme, Aishe Bakkar</option>
            <option>Khaled Bin ALWalid, Sakiyat AlJanzir</option>
            <option>All</option>
            </select>
            END;
    }else if($_SESSION['district'] == 'Bekaa'){
        echo<<<END
            <select id="troop-filter" onchange="filterTroop()">
            <option selected disabled>Select Troop</option>
            <option>Al Manara, Hammara</option>
            <option>Khaled Bin AlWalid, Majdel Anjar</option>
            <option>Taalabaya, Taalabaya</option>
            <option>All</option>
            </select>
            END;
    }else if($_SESSION['district'] == 'Mount Lebanon'){
        echo<<<END
            <select id="troop-filter" onchange="filterTroop()">
            <option selected disabled>Select Troop</option>
            <option>Al Iman, Daraya</option>
            <option>Al Farouk bin Omar AlKhattab, Ketermaya</option>
            <option>Al Iman, Barja</option>
            <option>Al Amin, Sibline</option>
            <option>All</option>
            </select>
            END;
    }else if($_SESSION['district'] == 'South'){
        echo<<<END
            <select id="troop-filter" onchange="filterTroop()">
            <option selected disabled>Select Troop</option>
            <option>Osama Bin Zayd, Saida</option>
            <option>Al Houssein Bin Ali, Ain EL Helwe</option>
            <option>Roukaya Bint AL Rassoul, AL hlayliya</option>
            <option>Al Sultan Mohamad Al Fatih, Abra</option>
            <option>All</option>
            </select>
            END;
    }else if($_SESSION['district'] == 'North'){
        echo<<<END
            <select id="troop-filter" onchange="filterTroop()">
            <option selected disabled>Select Troop</option>
            <option>Hamza Bin Abed AlMotaleb, Tripoli</option>
            <option>Salah Eddine AlAyoubi, Al Koura</option>
            <option>Omar Bin AlKhattab, AL Biddawi</option>
            <option>All</option>
            </select>
            END;
    }else if($_SESSION['district'] == 'Hasbaya and Marjayoun'){
        echo<<<END
            <select id="troop-filter" onchange="filterTroop()">
            <option selected disabled>Select Troop</option>
            <option>Hamza Bin Abed ALMottaleb , AL Hibariya</option>
            <option>Abou Taleb, Kfarchouba</option>
            <option>Osman bin Affan, Helta</option>
            <option>All</option>
            </select>
            END;
    }
    }
    ?>
    <input type="text" placeholder="Enter to search...   🔍" id="search" onkeyup="searchBook()">
<br>
    <br>
    <table class="myTable" id="myTable">
        <thead>
        <tr class="header">
            <th style="width:5%;">#</th>
            <th style="width:30%;">Name</th>
            <th style="width:25%;">Email</th>
            <th style="width:10%;">Points</th>
            <th style="width:10%;">Medals</th>
            <th style="width:10%;">Joined Since</th>
            <?php
            if($_SESSION['role'] == 'Troop Leader'||$_SESSION['role']=='Commander'){
            
            echo"<th style='width:20%;'>Role</th>";
            }
            ?>
        </tr>
        </thead>
        <tbody>
            
            <?php
            $count=1;
            while($rowGetMembers=$resultGetMembers->fetch()){
                if($rowGetMembers['role']=="Scout"){
                if($rowGetMembers['points']>=10){
                    $medals="🎗️";
                }
                if($rowGetMembers['points']>=20){
                    $medals="🎗️🏅";
                }
                if($rowGetMembers['points']>=30){
                    $medals="🎗️🏅🥇";
                }
                if($rowGetMembers['points']>=40){
                    $medals="🎗️🏅🥇🥉";
                }
                if($rowGetMembers['points']>=50){
                    $medals="🎗️🏅🥇🥉🎖️";
                }
            }
                if($rowGetMembers['role']=="Leader"){
                    $medals="🎗️🏅🥇🥉🎖️🏵️";
                }
                if($rowGetMembers['role']=="Troop Leader"){
                    $medals="🎗️🏅🥇🥉🎖️🏵️🛡️";
                }
                if($rowGetMembers['role']=="Commander"){
                    $medals="🎗️🏅🥇🥉🎖️🏵️🛡️⚜️";
                }
                echo<<<END
                <tr>
                <td>$count<span>$rowGetMembers[troop]</span><span>$rowGetMembers[usergroup]</span>                </td>
                <td>$rowGetMembers[firstname] $rowGetMembers[lastname]</td>
                <td>$rowGetMembers[email]</td>
                <td>$rowGetMembers[points]</td>
                <td>$medals</td>
                <td>$rowGetMembers[registerDate]</td>
                END;
                if($_SESSION['role'] =="Troop Leader"||$_SESSION['role'] =="Commander"){
                    if($rowGetMembers['role'] =="Troop Leader"){
                        $string="Troop Leader of $rowGetMembers[troop]";
                    }else if($rowGetMembers['role'] =="Commander"){
                        $string="Commander of $rowGetMembers[district]";
                    }else if($rowGetMembers['role'] =="Leader"){
                        $string="Leader of $rowGetMembers[usergroup]";
                    }else if ($rowGetMembers['role'] =="Scout"){
                    $string="Scout in $rowGetMembers[troop], $rowGetMembers[usergroup]";
                    }
                   echo" <td>$string</td>";
                   echo"</tr>";
                }else{
                    echo"</tr>";
                }
                $count++;
            }
            ?>
        </tbody>
    </table>
</div>

<?php include "footer.php"?>
<script>
        const search=document.getElementById("search");
        const rows=document.querySelectorAll(".myTable tbody tr");
        const troopFilter = document.getElementById("troop-filter");
        const groupFilter = document.getElementById("group-filter");
    function filter() {
    rows.forEach((row) => {
        var td=row.querySelectorAll("td");
        var data = td[0].querySelectorAll("span");
        
        if (
            (data[1].textContent === "All" ||
                groupFilter.selectedOptions[0].textContent === "All" ||
                groupFilter.selectedOptions[0].textContent === "Select Group" ||
                groupFilter.selectedOptions[0].textContent ===
                    data[1].textContent)
        ) {
            row.style.display = "table-row";
        } else {
            row.style.display = "none";
        }
    });
}
function filterTroop() {
    rows.forEach((row) => {
        var td=row.querySelectorAll("td");
        var data = td[0].querySelectorAll("span");
        
        if (
            (data[0].textContent === "All" ||
                troopFilter.selectedOptions[0].textContent === "All" ||
                troopFilter.selectedOptions[0].textContent === "Select troop" ||
                troopFilter.selectedOptions[0].textContent ===
                    data[0].textContent)&&
            (data[1].textContent === "All" ||
                groupFilter.selectedOptions[0].textContent === "All" ||
                groupFilter.selectedOptions[0].textContent === "Select Group" ||
                groupFilter.selectedOptions[0].textContent ===
                    data[1].textContent)
        ) {
            row.style.display = "table-row";
        } else {
            row.style.display = "none";
        }
    });
}
function searchBook(){
        let searchText = search.value.toLowerCase();
        rows.forEach((row) => {
        let book= row.querySelector("td:nth-child(2)");
        let bookName = book.textContent.toLowerCase();
        if (bookName.includes(searchText)) {

            row.style.display = "table-row";
        } else {
            row.style.display = "none";
        }
    });
        }
</script>
</body>
</html>