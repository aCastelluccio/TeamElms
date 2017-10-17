<!DOCTYPE html>

<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("vendor/phpauth/phpauth/Auth.php");
include("vendor/phpauth/phpauth/Config.php");

$dbh = new PDO("mysql:host=xq7t6tasopo9xxbs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=py6etou4vck57kfy", "d2qpf22lyarz395l", "pejiin9edn8xmt5a") or die("Can't connect to database");
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
?>

<html>

    <head>
        <meta name="accountRegistration">
        <meta charset="utf-8">
        <title>Account Activation</title>
    </head>
    
    <body>
        <header>Account Activation</header>
        
        <form method = "post" action = "<?php $_PHP_SELF ?>">
            Enter your activation key: <input type="text" name="key" id="key"><br>
            <button name="submit" type="submit">Submit</button>
        </form>
        
    </body>
    
    <?php
    $key = $_POST["key"];
    $tempKey = $auth->getRandomKey(20);
    echo $tempKey;
    $uid = $auth->getUID("kentharris5123@yahoo.com");
    $user = $auth->getUser($uid);
    if(isset($_POST["submit"])) {
        $auth->activate($key);
        header('Location: accountLogin.html');
        exit();
    }
    ?>

</html>