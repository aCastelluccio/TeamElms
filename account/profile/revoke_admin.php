<?php

require("../../vendor/phpauth/phpauth/Auth.php");
include("../../vendor/phpauth/phpauth/Config.php");

$dbh = new PDO("mysql:host=xq7t6tasopo9xxbs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=py6etou4vck57kfy", "d2qpf22lyarz395l", "pejiin9edn8xmt5a") or die("Can't connect to database");
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config);

$items = $_POST['checkbox'];

if (!isset($items)) {
    header('Location: ./remove_admin_account.php');
    exit();
}

for ($i = 0;  $i < count($items); $i++) {
    if ($items[$i] === "Yes") {
        $email = $items[$i+1];
        if ($email === "default") {
            continue;
        }
        $uid = $auth->getUID($email);
        $dbh->query("UPDATE user_info SET isAdmin=0 WHERE uid = $uid");
    }
}

header('Location: ./remove_admin_account.php');
exit()

?>