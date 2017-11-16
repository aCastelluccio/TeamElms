<?php

session_start();

if (isset($_SESSION['admin']) && ($_SESSION['admin'] === true)) {
    header('Location: ./adminpage.php');
    exit();
} else {
    header('Location: ./myprofile.php');
    exit();
}

?>