<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("authconnect.php"); 

$accEmail = $_POST["email"];
$confirm = $_POST["confirmation"];

$usertable = $dbh->query("SELECT id, password FROM `users` WHERE email = '$accEmail';", PDO::FETCH_ASSOC)->fetch();
$uid = $usertable['id'];
$pass = $usertable['password']; //$auth->getUser($uid) isn't returning the password in the array.. need to fix 
                                //this so $auth->deleteUser($uid, $pass) works.

if ($confirm === "DeleteAccount") {
    $delete = $auth->deleteUser($uid, $pass);
    
    if (!$delete['error']) {
        echo "User: " . $accEmail . " successfully deleted.";
    } else {
        echo $delete['message'];
    }
} else {
    echo "Please enter 'DeleteAccount' to delete this account.";
}
    
?>

<!-- The array getUser(uid) returns:

email (string): User's email address
password (string): User's password
salt (string): User's salt
isactive (boolean): Is user's account activated
uid (int): User's ID

-->
