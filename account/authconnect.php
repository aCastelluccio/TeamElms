<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../vendor/phpauth/phpauth/Auth.php");
include("../vendor/phpauth/phpauth/Config.php");

$dbh = new PDO("mysql:host=xq7t6tasopo9xxbs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=py6etou4vck57kfy", "d2qpf22lyarz395l", "pejiin9edn8xmt5a") or die("Can't connect to database");
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);

?>