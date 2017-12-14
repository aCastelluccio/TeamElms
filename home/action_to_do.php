<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../account/authconnect.php");

if (isset($_POST['emailPoster'])) {
    $photo = $_POST['emailPoster'];
    $sth = $dbh->prepare("SELECT poster_email FROM images_tbl WHERE images_path = '$photo'");
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC); 
    $poster_email = $result[0]['poster_email'];
    $_SESSION['emailPoster'] = $poster_email;
    header('Location: ../account/profile/');
    exit();
} else if (isset($_POST['reportPhoto'])) {
    $photo = $_POST['reportPhoto'];
    $dbh->query("UPDATE images_tbl SET reported=1 WHERE images_path = '$photo'");
}

header('Location: ./');
exit();

?>