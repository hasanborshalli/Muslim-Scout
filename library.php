<?php
require_once ("config.php");
session_start();
try{
$pdo= new PDO(DBCONNSTRING,DBUSER,DBPASS);
$queryGetBooks="SELECT * FROM library where is_deleted='false' order by averageRate desc";
$resultGetBooks=$pdo->query($queryGetBooks);


}catch(PDOException $e){
    die($e->getMessage());
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/library.css">
    <link rel="icon"  href="img/logoo.png">
    <title>Library</title>
</head>
<body>
<?php include "header.php"?>

<div class="container">
    <h2 align="center">Digital Library</h2>
    <input type="text" placeholder="Enter to search...   🔍" id="search" onkeyup="searchBook()">

    <br>
    <table class="myTable" id="myTable">
        <thead>
        <tr class="header">
            <th style="width:5%;">ID</th>
            <th style="width:70%;">Title</th>
            <th style="width:25%;">Rate</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i=1;
        while($rowGetBooks=$resultGetBooks->fetch()){
            echo <<<EOF
            <tr id="$rowGetBooks[id]">
            <td>$i</td>
            <td class="books"><a href="$rowGetBooks[link]" target="_blank">$rowGetBooks[title]</a></td>
            <td><button class="star" onclick="rate(1,$rowGetBooks[id])">&#9733;</button><button class="star" onclick="rate(2,$rowGetBooks[id])">&#9733;</button><button class="star" onclick="rate(3,$rowGetBooks[id])">&#9733;</button><button class="star" onclick="rate(4,$rowGetBooks[id])">&#9733;</button><button class="star" onclick="rate(5,$rowGetBooks[id])">&#9733;</button><p class='rating'>$rowGetBooks[averageRate]</p></td>
            </tr>
            EOF;
            $i++;
        
    echo<<<EOF
    <div class="review" id="review$rowGetBooks[id]">
    <h1 align="center" style="color:#59188c">Reviews of $rowGetBooks[title]</h1>
    EOF;
    $queryGetReviews="SELECT * FROM rated where bookId = $rowGetBooks[id]";
    $resultGetReviews=$pdo->query($queryGetReviews);
    $rowGetReviewsCount=$resultGetReviews->rowCount();
    if($rowGetReviewsCount>0){
    while($rowGetReviews=$resultGetReviews->fetch()){
    $queryGetReviewer="SELECT firstname,lastname FROM user where id='$rowGetReviews[userId]'";
    $resultGetReviewer=$pdo->query($queryGetReviewer);
    $rowGetReviewer=$resultGetReviewer->fetch();
    echo<<<EOF
    <div class="review-container" id="$rowGetReviews[rate]">
    <h3>$rowGetReviewer[firstname] $rowGetReviewer[lastname]</h3>
    <p id="leftreview">$rowGetReviews[review]</p>
    <p id="reviewstars"><button class="reviewstars">&#9733;</button><button class="reviewstars">&#9733;</button><button class="reviewstars">&#9733;</button><button class="reviewstars">&#9733;</button><button class="reviewstars">&#9733;</button></p>
    <hr>
    </div>
    <br>
    EOF;
    
    }
}
    echo<<<EOF
    <textarea name="review" id="add-review$rowGetBooks[id]" cols="50" rows="10"></textarea>
    <input type="button" value="submit review" id="" onclick="submitReview($rowGetBooks[id])">
    </div>
    EOF;
}
$queryCheckRated2="SELECT * from rated where userId='$_SESSION[id]'";
$resultCheckRated2=$pdo->query($queryCheckRated2);
$rowCheckRatedCount2=$resultCheckRated2->rowCount();
if($rowCheckRatedCount2>0){
 while($rowCheckRated2=$resultCheckRated2->fetch()){
    echo <<<EOF
        <script>
        var parentRow =document.getElementById('$rowCheckRated2[bookId]');
        var allStars = parentRow.querySelectorAll('.star');
          allStars.forEach(function(star) {
            star.style.color = '#ccc';
          });
        
          for (var i = 0; i < $rowCheckRated2[rate]; i++) {
            allStars[i].style.color = 'yellow';
          }
        </script>
    EOF;
 }

}
        ?>
        </tbody>
    </table>
</div>

<?php include "footer.php"?>
<?php
    
    ?>
    <script>
        const search=document.getElementById("search");
        const rows=document.querySelectorAll(".myTable tbody tr");
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
        function rate(stars,id) {
            <?php
                $queryCheckRated="SELECT * from rated where userId='$_SESSION[id]'";
                $resultCheckRated=$pdo->query($queryCheckRated);
                $rowCheckRatedCount=$resultCheckRated->rowCount();
                if($rowCheckRatedCount>0){
                    while($rowCheckRated=$resultCheckRated->fetch()){
                    echo<<<EOF
                        
                        if(id==$rowCheckRated[bookId]&&stars==$rowCheckRated[rate]){
                            return ;
                        }
                    EOF;
                }
            }
            ?>
            var review=document.getElementById("review"+id);
            var submit=review.querySelector("input[type=button]");
            submit.id=stars;
            var reviews=document.querySelectorAll('.review');
            if(review.style.display=="block"){
                review.style.display="none";
            }else{
                reviews.forEach(function(reviewone){
                    reviewone.style.display="none";
                });
                review.style.display="block";

        var reviewContainers=document.querySelectorAll('.review-container');
        reviewContainers.forEach(function(review){
            var allStars = review.querySelectorAll(".reviewstars");
          allStars.forEach(function(star) {
            star.style.color = '#ccc';
          });
        
          for (var i = 0; i < review.id; i++) {
            allStars[i].style.color = 'yellow';
          }
            
        });
         
    }
//  window.location.href="rate.php?id="+id+"&stars="+stars;

}
function submitReview(bookId) {
var reviewValue=document.getElementById("add-review"+bookId).value;

var review=document.getElementById("review"+bookId);
var submit=review.querySelector("input[type=button]");
window.location.href="rate.php?bookId="+bookId+"&review="+reviewValue+"&stars="+submit.id;
}

    </script>
</body>
</html>