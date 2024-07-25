<?php
 require_once ("config.php");
 session_start();
 try{
    $pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
    if(isset($_SESSION['loggedin'])&&($_SESSION['role']=="It")){
        $queryGetBooks="SELECT * FROM library where is_deleted='false'";
        $resultGetBooks=$pdo->query($queryGetBooks);
        $resultGetBooks2=$pdo->query($queryGetBooks);

        $queryGetNews="SELECT * from news where is_deleted='false'";
        $resultGetNews=$pdo->query($queryGetNews);
        $resultGetNews2=$pdo->query($queryGetNews);
    }else{
        header("Location:logout.php");
    exit;

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
    <title>IT Dashboard</title>
    <link rel="stylesheet" href="css/it.css">
    <link rel="icon"  href="img/logoo.png">
</head>
<body>
<h4>IT Dashboard</h4>
   <div class="main">

<section class="container">  
<input type="button" class="left-buttons" value="📰  Add News" onclick="addnewformShow()">
<input type="button" class="left-buttons" value="🛠  Edit News" onclick="editnewformShow()">
<input type="button" class="left-buttons" value="❌  Delete News" onclick="deletenewformShow()">
<input type="button" class="left-buttons" value="📚  Add Books" onclick="addbookformShow()">
<input type="button" class="left-buttons" value="🛠  Edit Books" onclick="editbookformShow()">
<input type="button" class="left-buttons" value="❌  Delete Books" onclick="deletebookformShow()">
<input type="button" class="left-buttons" value="↩  Logout" onclick="window.location.href='logout.php'">
   </section>

   <div class="addnews">

    <div class="header" id="header">
        <p>Add News</p> 
    </div>

    <form method="post" class="addnewform" id="addnewform" enctype='multipart/form-data' action="addnew.php">
        <input type="file" name="photo" required>
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="description" placeholder="Description" id="description" required>
        <input type="submit" value="Post New" id="submit-button">
    </form>

    <form method="post" class="addnewform" id="addbookform" action="addbook.php">
        <input type="text" name="titlebook" placeholder="Title" required>
        <input type="text" name="link" placeholder="Link" id="Link" required>
        <input type="submit" value="Post book" id="submit-button">
    </form>

    <form method="post" class="addnewform" id="editnewform" >
    <input type="text" placeholder="Enter to search...   🔍" id="searchNews" onkeyup="searchNew()">
    <ol class="applist" id="NewappList">
        <?php
        while($rowGetNews2=$resultGetNews2->fetch()){
            echo<<<EOF
            <li onclick="startEditNew($rowGetNews2[id],'$rowGetNews2[title]','$rowGetNews2[description]','$rowGetNews2[photo]')">$rowGetNews2[title]</li>
            EOF;
        }
        
        ?>
        </ol>
    </form>
    <form method="post" id="startEditNew" class="addnewform" action="editnew.php" enctype='multipart/form-data'>
    <img src="" id="photo" name="photoEdit2">
    <input type="file" name="photoEdit" id="photoEdit">
    <input type="hidden" name="idEdit" id="idEdit">
        <input type="text" name="titleEdit" id="titleEdit" placeholder="Title" required>
        <input type="text" name="descriptionEdit" placeholder="Description" id="descriptionEdit" required>
        <input type="submit" value="Edit New" id="submit-button">
    </form>
    <form method="post" class="addnewform" id="editbookform" >
    <input type="text" placeholder="Enter to search...   🔍" id="searchBooks" onkeyup="searchBook()">
    <ol class="applist" id="BookappList">
        <?php
        while($rowGetBooks2=$resultGetBooks2->fetch()){
            echo<<<EOF
                <li onclick="startEditBook('$rowGetBooks2[title]','$rowGetBooks2[link]',$rowGetBooks2[id])">$rowGetBooks2[title]</li>
            EOF;
        }
        
        ?>
        </ol>
    </form>
    <form method="post" id="startEditBook" class="addnewform" action="editbook.php">
    <input type="hidden" name="idEditBook" id="idEditBook">
        <input type="text" name="titleEditBook" id="titleEditBook" placeholder="Title" required>
        <input type="text" name="linkEditBook" placeholder="Link" id="linkEditBook" required>
        <input type="submit" value="Edit Book" id="submit-button">
    </form>
    <form id="deletenewform">
        <ol>
            <?php
                while($rowGetNews=$resultGetNews->fetch()){
                    echo<<<EOF
                        <li><div class="mainLi"><div class="book-title">$rowGetNews[title]</div><span onclick="deleteNew($rowGetNews[id],'$rowGetNews[title]')">❌</span></div></li>
                    EOF;
                }
            ?>
        </ol>
    </form>
    <form id="deletebookform">
        <ol>
            <?php
                while($rowGetBooks=$resultGetBooks->fetch()){
                    echo<<<EOF
                        <li><div class="mainLi"><div class="book-title">$rowGetBooks[title]</div><span onclick="deleteBook($rowGetBooks[id],'$rowGetBooks[title]')">❌</span></div></li>
                    EOF;
                }
            ?>
        </ol>
    </form>

    <div class="confirm" id="confirm">
        <p id="confirm-header"></p>
        <div class="buttons">
            <button onclick="decline()">No</button>
            <button id="yes" onclick="accept()">Yes</button>
            <button id="yes2" onclick="accept2()">Yes</button>
        </div>
    </div>
</div>
<script src="js/it.js"></script>
</body>
</html>