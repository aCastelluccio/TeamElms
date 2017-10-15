<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("connect.php");
include("cipher.php");

$firstname = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
$lastname = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
$email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
if ($_POST["password"] !== $_POST["password_confirm"]){
    $password = null;
    echo "Passwords do not match. ";
} else {
    $password = $_POST["password"];
    //$password = generate_hash($temp, 11);
}

//Checking if the user filled out all fields 
if (!isset($firstname) || !isset($lastname) || !isset($username) || !isset($email) || !isset($password) || !isset($_POST["password_confirm"])) {
    echo "Please fill out all fields. ";
}

//Checking if the username already exists
if (mysqli_query($link, "SELECT username FROM `user` WHERE username = '$username'")) {
    $error = "Username appears to already be taken... ";
}

//Validating email and making sure it does not already exist
if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) && (!mysqli_query($link, "SELECT email FROM `user` WHERE email = '$email'"))){
    $error = "Enter a valid email. ";
}

$populateUsrTbl = "INSERT INTO `user` (username, password, first_name, last_name, email) VALUES ('$username', '$password', '$firstname', '$lastname', '$email')";

if (mysqli_query($link, $populateUsrTbl)) {
} else {
    echo "Error: " . $populateUsrTbl . "<br>" . mysqli_error($link);
}

$accountTableSQL = "INSERT INTO account (id) SELECT id FROM `user` WHERE NOT EXISTS (SELECT id FROM account WHERE `account`.id = `user`.id) LIMIT 1";

if (mysqli_query($link, $accountTableSQL)) {
    header('Location: accountLogin.html');
    exit();
} else {
    echo "Error: " . $accountTableSQL . "<br>" . mysqli_error($link);
}

mysqli_close($link);

//TO-DO: Secure auth token
//TO-DO: Check if an email is valid
//TO-DO: Check if an email is not already taken
//TO-DO: Check if a username is not already taken
//TO-DO: Errors if passwords don't match
//TO-DO: Minimum requirements on passwords

// $ip = $_SERVER['REMOTE_ADDR']; HOW TO GET THE IP OF A USER
?>
