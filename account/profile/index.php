<!DOCTYPE html>
<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../../vendor/phpauth/phpauth/Auth.php");
include("../../vendor/phpauth/phpauth/Config.php");

$dbh = new PDO("mysql:host=xq7t6tasopo9xxbs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=py6etou4vck57kfy", "d2qpf22lyarz395l", "pejiin9edn8xmt5a") or die("Can't connect to database");
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config);

if (isset($_SESSION['admin']) && ($_SESSION['admin'] === true)) { ?>
    <script>
        window.location.href = "./adminpage.php";
    </script>
<?php }

if (isset($_SESSION['emailPoster']) && $_SESSION['emailPoster'] !== "") {
    $emailS = $_SESSION['emailPoster'];
} else {
    $emailS = $_SESSION['email'];
}

$sth = $dbh->prepare("SELECT u.email, ui.first_name, ui.last_name FROM user_info ui JOIN users u ON ui.uid = u.id WHERE ui.approved = 1 AND u.email = '$emailS' ");
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);


//Implement if more than one user 

function searchForUser($email, $dbh) {
    $sth = $dbh->prepare("SELECT u.email, ui.first_name, ui.last_name FROM user_info ui JOIN users u ON ui.uid = u.id WHERE ui.approved = 1 AND u.email = '$email' ");
    $sth->execute();
    $search = $sth->fetchAll(PDO::FETCH_ASSOC);
    
    return $search;
    
}

if (isset($_GET['user'])) {
    
    $email = $_GET['user'];
    $search = searchForUser($email, $dbh);
    
    if($search) {
        $result[0]['first_name'] = $search[0]['first_name'];
        $result[0]['last_name'] = $search[0]['last_name'];
        $result[0]['email'] = $search[0]['email'];
    }
}

?>

<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <title>Acorn Academy - User Profiles</title>

    <!-- Bootstrap core CSS -->
    <link href="../../_layout/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../_layout/css/portfolio-item.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="../../home/">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
<!--
            <li class="nav-item">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                    <input name="user" id="user" type="text" placeholder="Enter an email.">
                </form>
            </li>
-->
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <!-- Portfolio Item Heading -->
      <h1 class="my-4"><?php echo $result[0]['first_name'] . ' ' . $result[0]['last_name']; ?></h1>

      <!-- Portfolio Item Row -->
      <div class="row">

        <div class="col-md-3 col-sm-6 mb-4">
          <a>
              <img data-toggle="modal" data-target="#myModal" class="img-fluid" src="http://placehold.it/500x500" alt="">
          </a>
        </div>

        <div class="col-md-4">
          <h3 class="my-3">User Details</h3>
          <ul>
            <li>Email Address: <?php echo $result[0]['email'] ?></li>
          </ul>
        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

      
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Profile Picture</h4>
            </div>
            <div class="modal-body">
              <button>Upload a picture</button>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-default">Submit</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    <!-- Bootstrap core JavaScript -->
    <script src="../../_layout/jquery/jquery.min.js"></script>
    <script src="../../_layout/js/bootstrap.bundle.min.js"></script>

  </body>

</html>