<?php
$password="Hasan";
$salt=bin2hex(random_bytes(6));
$saltedpassword=substr($salt,0,6).$password.substr($salt,6,5);
$hashpwd=hash('sha256',$saltedpassword);
echo $salt."<br>";
echo $saltedpassword."<br>";
echo $hashpwd."<br>";
?>