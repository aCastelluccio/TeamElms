<!DOCTYPE html>

<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("vendor/phpauth/phpauth/Auth.php");
include("vendor/phpauth/phpauth/Config.php");

$dbh = new PDO("mysql:host=localhost;dbname=phpauth", "root", "root") or die("Can't connect to database");
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
        
        <form action="<?php $_PHP_SELF ?>" method="post">
            Enter the activation key sent to your email: <input type="text" name="key"><br>
            <button name="submit" type="submit">Submit</button>
        </form>
        
        <?php
              $key = $_POST["key"];
              
              if($key['error']) {
                  echo $key['message'];
              } else {
                  auth->activate($key);
              }
        ?>
        
    </body>

</html>