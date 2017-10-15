<?php 

$mysqlUsr = 'root';
$mysqlPass = 'root';
$db = 'Authentication';         //Will need to be changed depending on the live servers database name.
$host = 'localhost';
$port = 8889;

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