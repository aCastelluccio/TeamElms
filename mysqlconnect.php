<?php
$user = 'root';
$password = 'root';
$db = 'photoInfo';
$host = 'localhost';
$port = 8889;

$link = mysqli_init();
$conn = mysqli_real_connect(
   $link, 
   $host, 
   $user, 
   $password, 
   $db,
   $port
);
if($conn)
{
    $db_selected = mysqli_select_db($link, $db);
    if (!$db_selected) {
        die ('Can\'t use foo : ' . mysqli_error());
    }
}
else
{
    die('Not connected : ' . mysqli_error());
}
?>
