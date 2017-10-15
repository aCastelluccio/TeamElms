<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("./ZxcvbnPhp/Matchers/MatchInterface.php");
require("./ZxcvbnPhp/Matchers/Match.php");
require("./ZxcvbnPhp/Matchers/DigitMatch.php");
require("./ZxcvbnPhp/Matchers/Bruteforce.php");
require("./ZxcvbnPhp/Matchers/YearMatch.php");
require("./ZxcvbnPhp/Matchers/SpatialMatch.php");
require("./ZxcvbnPhp/Matchers/SequenceMatch.php");
require("./ZxcvbnPhp/Matchers/RepeatMatch.php");
require("./ZxcvbnPhp/Matchers/DictionaryMatch.php");
require("./ZxcvbnPhp/Matchers/L33tMatch.php");
require("./ZxcvbnPhp/Matchers/DateMatch.php");
require("./ZxcvbnPhp/Matcher.php");
require("./ZxcvbnPhp/Searcher.php");
require("./ZxcvbnPhp/ScorerInterface.php");
require("./ZxcvbnPhp/Scorer.php");
require("./ZxcvbnPhp/Zxcvbn.php");

use ZxcvbnPhp\Zxcvbn;

require("vendor/phpauth/phpauth/Auth.php");
include("vendor/phpauth/phpauth/Config.php");
//include("connect.php");

$dbh = new PDO("mysql:host=localhost;dbname=phpauth", "root", "root") or die("Can't connect to database");
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);

$dbh->exec("DELETE FROM attempts;");
$dbh->exec("DELETE FROM users;");
$dbh->exec("DELETE FROM sessions;");
$dbh->exec("DELETE FROM requests;");

$firstname = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
$lastname = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
$email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
$passwordconform = filter_var($_POST["password_confirm"], FILTER_SANITIZE_STRING);
$params = array("FirstName" => "{$firstname}", "LastName" => "{$lastname}", "Username" => "{$username}");

$result = $auth->register($email, $password, $passwordconform, $params = array(), $sendmail = TRUE);

if ($result['error']) {
    echo $result['message'];
}

//Login
//if ($login['error'] == false) {
//            setcookie($config->cookie_name, $login['hash'], $login['expire'], $config->cookie_path, $config->cookie_domain, $config->cookie_secure, $config->cookie_http);
//            header("Location: /accountLogin");
//        }
