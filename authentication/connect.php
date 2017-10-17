<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mysqlUsr = 'd2qpf22lyarz395l';
$mysqlPass = 'pejiin9edn8xmt5a';
$db = 'py6etou4vck57kfy';
$host = 'xq7t6tasopo9xxbs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
$port = 3306;

$link = mysqli_init();
$conn = mysqli_real_connect(
    $link, 
    $host, 
    $mysqlUsr, 
    $mysqlPass, 
    $db,
    $port
);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>