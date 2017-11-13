<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../vendor/ZxcvbnPhp/Matchers/MatchInterface.php");
require(".//vendor/ZxcvbnPhp/Matchers/Match.php");
require("./vendor/ZxcvbnPhp/Matchers/DigitMatch.php");
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
    
$dbh->exec("DELETE FROM attempts;");
$dbh->exec("DELETE FROM users;");
$dbh->exec("DELETE FROM sessions;");
$dbh->exec("DELETE FROM requests;");

$firstname = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
$lastname = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
$email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
$passwordconform = filter_var($_POST["password_confirm"], FILTER_SANITIZE_STRING);
$params = array("FirstName" => "{$firstname}", "LastName" => "{$lastname}");

$schoolKey = $_POST['schoolKey'];

$register = $auth->register($email, $password, $passwordconform, $params = array(), $sendmail = TRUE); //$captcha = "aD1pZ7"
//Test Password: My1Password2!haha@

if ($schoolKey === 'acorn') {
    if (!$register['error']) {                            //-
        header('Location: activateInput(testing).php');   //This is for testing purposes without a properly set config.sql
        exit();                                           //-
    } else {                                           
        echo $register['message'];
    }
} else {
    echo "Please enter the correct school key.";
}
    
?>
