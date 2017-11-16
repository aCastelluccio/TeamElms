<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("authconnect.php");

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
$_SESSION['active_session'] = false;

//Login
if ((!$auth->isLogged()) && (!$login['error'])) {
        
    $_SESSION['active_session'] = true;
    $_SESSION['email'] = $email;
    
    if ($email === 'admin@drew.edu') {
        $_SESSION['admin'] = true;
    } else {
        $_SESSION['admin'] = false;
    }
        
    setcookie($config->cookie_name, $login['hash'], $login['expire'], $config->cookie_path, $config->cookie_domain, $config->cookie_secure, $config->cookie_http);
        
    header("Location: ../home/");
    exit();
    
} else {
    
    echo $login['message'];
    
}
    
?>