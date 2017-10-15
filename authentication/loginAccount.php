<?php

include("connect.php");
include("cipher.php");

$loginUsername = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
$loginPassword = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

if ($conn) {
    $usrPassSQL = mysqli_query($link, "SELECT password FROM `user` WHERE username = '$loginUsername'");
}

$sqlResult = mysqli_fetch_assoc($usrPassSQL);
$usrPassword = $sqlResult['password'];

if ($usrPassword === $loginPassword) {
    header('Location: /CamilleTestFile.html');                  //Redirect to main website
    exit();
} else {
    echo 'Your username or password is incorrect.';
}

//With cipher.php encryption -- trying to compare hashed password to user's inputed password
//if (validate_pw($loginPassword, $usrPassword)) {
//    header('Location: /CamilleTestFile.html');                  //Redirect to main website
//    exit();
//} else {
//    echo 'Your username or password is incorrect.';
//    echo ' Login pw: ' . $loginPassword . ' Pw in database: ' . $usrPassword;
//}

mysqli_close($conn);

//TO-DO: If # of failed attempts of logging in, then require captcha. 
//TO-DO: Redirect to main website
?>