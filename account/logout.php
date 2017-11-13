<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("authconnect.php");

$email = $_SESSION['user_email'];
$hash = $dbh->query("SELECT hash FROM sessions WHERE uid = (SELECT id FROM users WHERE email = '$email');", PDO::FETCH_ASSOC)->fetch()['hash'];

$logout = $auth->logout($hash);
    
if ($logout) {
    $_SESSION['active_session'] = 0;
    header('Location: index.html');
    exit();
} else {
    echo "You were unable to successfully logout. Confirm whether you were recently logged in; if you were not, then you cannot logout.";
}

?>