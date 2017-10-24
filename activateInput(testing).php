<!DOCTYPE html>

<?php

include("authconnect.php");

?>

<html>
    <head>
        <meta name="accountLogin">
        <meta charset="utf-8">
        <title>Account Login</title>
    </head>

    <body>
        <form action="index.html" method="post">
            Activation Key: <input type="text" name="actKey"><br>
            <button name="loginButton" type="submit">Activate</button>
        </form>
    </body>
    
    <?php
    
    $tempKey = $auth->getRandomKey(20);
    echo $tempKey;
    
    ?>

</html>