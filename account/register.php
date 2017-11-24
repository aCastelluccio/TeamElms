<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../vendor/ZxcvbnPhp/Matchers/MatchInterface.php");
require("../vendor/ZxcvbnPhp/Matchers/Match.php");
require("../vendor/ZxcvbnPhp/Matchers/DigitMatch.php");
require("../vendor/ZxcvbnPhp/Matchers/Bruteforce.php");
require("../vendor/ZxcvbnPhp/Matchers/YearMatch.php");
require("../vendor/ZxcvbnPhp/Matchers/SpatialMatch.php");
require("../vendor/ZxcvbnPhp/Matchers/SequenceMatch.php");
require("../vendor/ZxcvbnPhp/Matchers/RepeatMatch.php");
require("../vendor/ZxcvbnPhp/Matchers/DictionaryMatch.php");
require("../vendor/ZxcvbnPhp/Matchers/L33tMatch.php");
require("../vendor/ZxcvbnPhp/Matchers/DateMatch.php");
require("../vendor/ZxcvbnPhp/Matcher.php");
require("../vendor/ZxcvbnPhp/Searcher.php");
require("../vendor/ZxcvbnPhp/ScorerInterface.php");
require("../vendor/ZxcvbnPhp/Scorer.php");
require("../vendor/ZxcvbnPhp/Zxcvbn.php");

use ZxcvbnPhp\Zxcvbn;

include("authconnect.php");

//For testing:  My#Password1!2@345

$first_name = ucfirst(filter_var($_POST["first_name"], FILTER_SANITIZE_STRING));
$last_name = ucfirst(filter_var($_POST["last_name"], FILTER_SANITIZE_STRING));
$email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
$passwordconform = filter_var($_POST["password_confirm"], FILTER_SANITIZE_STRING);

$registerParams = array("email" => "{$email}", "password" => "{$password}", "password_confirm" => "{$passwordconform}");
$params = array("first_name" => "{$first_name}", "last_name" => "{$last_name}", "email" => "{$email}");

$register = $auth->register($email, $password, $passwordconform);

if (!$register['error']) {
        
    $uid = $auth->getUID($email);
    $dbh->query("INSERT INTO user_info(uid, first_name, last_name) VALUES('".$uid."','".$params['first_name']."','".$params['last_name']."')");
    
    $dbh->query("INSERT INTO pending_registration_requests(email, first_name, last_name) VALUES('".$registerParams['email']."','".$params['first_name']."','".$params['last_name']."' )");
    
    header('Location: ./');
    exit();

} else { ?>

        <script text="text/javascript">
            alert("<?php echo $register['message']; ?>");
            window.location.href = "./register.html";
        </script>

<?php }
    
?>
