<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Duplication</title>
    <!-- this is for font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <link rel="icon"  href="img/logoo.png">
    <link rel="stylesheet" href="css/error.css">
</head>
<body>
    <div class="error-div">
        <img src="img/error.png">
        <h1 id="error-header">Oops! Looks like you've created a clone!</h1>
        <h3 id="error-message"></h3>
        <button onclick="window.location.href='hr.php'" id="backButton">Go Back</button>
    </div>
    <script>
        const errorMessage=document.getElementById('error-message');
        const errorHeader=document.getElementById('error-header');
        const backButton=document.getElementById('backButton');
        var url = window.location.href;
        var parameters=url.split('?');
        var errorValue= parameters[1].split('=');
        if(errorValue[1]=="email"){
            errorMessage.innerHTML="Please press back and enter another email address";
        }else if(errorValue[1]=="phone"){
            errorMessage.innerHTML="Please press back and enter another phone number";
        }else if(errorValue[1]=="leader"){
            errorHeader.innerHTML="Whoops! Looks like this group already has a fearless leader! One leader at a time, please.";
            errorMessage.innerHTML="";
        }else if(errorValue[1]=="date"){
            errorHeader.innerHTML="Oops! Looks like your day's as packed as a scout's survival kit. Let's give those activities some breathing room, okay?";
            errorMessage.innerHTML="";
            backButton.onclick=function(){
                window.location.href="activity.php";
            }
        }
        else if(errorValue[1]=="dateWork"){
            errorHeader.innerHTML="Oops! Looks like your day's as packed as a scout's survival kit. Let's give those activities some breathing room, okay?";
            errorMessage.innerHTML="";
            backButton.onclick=function(){
                window.location.href="Volunteer.php";
            }
        }
    </script>
</body>
</html>