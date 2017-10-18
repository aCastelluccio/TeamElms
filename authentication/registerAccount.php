<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("connect.php");

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
$schoolKey = $_POST['schoolKey'];


//Checking if the user filled out all fields 
if (!isset($firstname) || !isset($lastname) || !isset($username) || !isset($email) || !isset($password) || !isset($_POST["password_confirm"])|| !isset($schoolKey)) {
    echo "Please fill out all the boxes. ";
}

//Checking if the username already exists
if (mysqli_query($link, "SELECT username FROM `user` WHERE username = '$username'")) {
    echo = "Username appears to already be taken... ";
}

//Validating email and making sure it does not already exist
if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) && (!mysqli_query($link, "SELECT email FROM `user` WHERE email = '$email'"))){
    echo = "Email is either not valid or already taken. ";
}

if ($schoolKey !== 'acorn') {
    echo "The school key you entered is not correct. Please enter the key given to you. ";
}

$populateUsrTbl = "INSERT INTO `user` (username, password, first_name, last_name, email) VALUES ('$username', '$password', '$firstname', '$lastname', '$email')";

if (mysqli_query($link, $populateUsrTbl)) {
} else {
    echo "Error: " . $populateUsrTbl . "<br>" . mysqli_error($link);
}

$accountTableSQL = "INSERT INTO account (id) SELECT id FROM `user` WHERE NOT EXISTS (SELECT id FROM account WHERE `account`.id = `user`.id) LIMIT 1";

if (mysqli_query($link, $accountTableSQL)) {
    header('Location: tempHome.html');
    exit();
} else {
    echo "Error: " . $accountTableSQL . "<br>" . mysqli_error($link);
}

mysqli_close($link);

?>
