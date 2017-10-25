<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("authconnect.php");

//Function -- Uncomment below code to purge all phpauth-related tables on the live site.
//$dbh->exec("DELETE FROM attempts;");
//$dbh->exec("DELETE FROM config;");
//$dbh->exec("DELETE FROM requests;");
//$dbh->exec("DELETE FROM sessions;");
//$dbh->exec("DELETE FROM users;");
    
$email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

$checkbox = $_POST['rememberSession'];
$remember = null;
if ($checkbox === "YES") {
    $remember = true;
} else {
    $remember = false;
}

$login = $auth->login($email, $password, $remember);

$_SESSION['session_expirationdate'] = $dbh->query("SELECT expiredate FROM sessions WHERE uid = (SELECT id FROM users WHERE email = '$email');", PDO::FETCH_ASSOC)->fetch()['expiredate'];
$hash = $dbh->query("SELECT hash FROM sessions WHERE uid = (SELECT id FROM users WHERE email = '$email');", PDO::FETCH_ASSOC)->fetch()['hash'];

//$now = new DateTime();
//$now->format('Y-m-d H:i:s');    // MySQL datetime format
//$now->getTimestamp(); 

//TO-DO: Make this more clear and improve code
//Making sure that the to-be newly instantiated session meets a couple of conditions first: 
//1 - the current timestamp when logging-in isn't before the previous session's expiration or
//2 - there isn't already an active session for the user
if (($now <= $_SESSION['session_expirationdate']) || (!$auth->checkSession($hash))) {
    $_SESSION['active_session'] = 0;
} else {
    $_SESSION['active_session'] = 1;
    //For the the logout method in temporary use.
    $_SESSION['user_email'] = $email;
}

//Login
if (!$auth->isLogged()) {
    if ($login['error'] == false) {
        setcookie($config->cookie_name, $login['hash'], $login['expire'], $config->cookie_path, $config->cookie_domain, $config->cookie_secure, $config->cookie_http);
        header("Location: Welcome_Page.php");
        exit();
    } else {
        echo $login['message'];
    }
} else {
    header('HTTP/1.0 403 Forbidden');
    exit();
}
    
?>