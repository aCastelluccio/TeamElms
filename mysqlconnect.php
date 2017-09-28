<?php
$user = 'd2qpf22lyarz395l';
$password = 'pejiin9edn8xmt5a';
$db = 'py6etou4vck57kfy';
$host = 'xq7t6tasopo9xxbs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com	';
$port = 3306;

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
