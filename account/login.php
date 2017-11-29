<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("authconnect.php");

$email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

$checkbox = $_POST['rememberSession'];
if ($checkbox === "YES") {
    $_SESSION['remember'] = $email;
    $_SESSION['isChecked'] = true;
    $remember = true;
} else {
    $_SESSION['remember'] = null;
    $_SESSION['isChecked'] = null;
    $remember = false;
}

$_SESSION['active_session'] = false;

$uid = $auth->getUID($email);
$sth = $dbh->prepare("SELECT approved FROM user_info WHERE uid = $uid");
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);

if ($result['approved'] === "1") {
    $login = $auth->login($email, $password, $remember);
    //Login
    if (!$login['error']) {

        $_SESSION['active_session'] = true;
        $_SESSION['email'] = $email;
        
        $sth = $dbh->prepare("SELECT isAdmin FROM user_info WHERE uid = $uid");
        $sth->execute();
        $admin = $sth->fetch(PDO::FETCH_ASSOC)['isAdmin'];

        if ($admin === 1) {
            $_SESSION['admin'] = true;
        } else {
            $_SESSION['admin'] = false;
        }

        setcookie($config->cookie_name, $login['hash'], $login['expire'], $config->cookie_path, $config->cookie_domain, $config->cookie_secure, $config->cookie_http);

        header("Location: ../home/");
        exit();

    } else { ?>

        <script text="text/javascript">
            alert("<?php echo $login['message']; ?>");
            window.location.href = "./";
        </script>

    <?php }
    
} else { ?>
    <script text="text/javascript">
        alert("Your account has not been approved yet. Please wait for an administer to approve your registration request before attempting to login.");
        window.location.href = "./";
    </script>
<?php }
    
?>