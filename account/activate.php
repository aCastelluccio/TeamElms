<!DOCTYPE html>

<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("authconnect.php");

include("activateInput(testing)"); //For testing purposes

?>

<html>

    <head>
        <meta name="accountRegistration">
        <meta charset="utf-8">
        <title>Account Activation</title>
    </head>
    
    <body>
        <header>Account Activation</header>
        
        <form method = "post" action = "<?php $_PHP_SELF ?>">
            Enter your activation key: <input type="text" name="key" id="key"><br>
            <button name="submit" type="submit">Submit</button>
        </form>
        
    </body>
    
    <?php
    
    $enteredKey = $_["actKey"];
    
    $key = $_POST["key"];    

    if( $enteredKey === $key ) {
        $auth->activate($enteredKey);
        header('Location: login.php');
        exit();
    }
              
    ?>

</html>