<!DOCTYPE html>
<?php

require("../../vendor/phpauth/phpauth/Auth.php");
include("../../vendor/phpauth/phpauth/Config.php");

$dbh = new PDO("mysql:host=xq7t6tasopo9xxbs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=py6etou4vck57kfy", "d2qpf22lyarz395l", "pejiin9edn8xmt5a") or die("Can't connect to database");
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config);

$sth = $dbh->prepare("SELECT COUNT(u.email) FROM users u JOIN user_info ui ON ui.uid = u.id WHERE ui.approved = 0 ");
$sth->execute();
$number_of_requests = $sth->fetchColumn(); 

$sth2 = $dbh->prepare("SELECT COUNT(reported) FROM images_tbl WHERE reported = 1 ");
$sth2->execute();
$number_of_reports = $sth2->fetchColumn(); 

$updatedAt = date('h:i a');

?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Admin Page</title>
  <!-- Bootstrap core CSS-->
  <link href="../../_layout/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="../../_layout/font-awesome/css/font-awesome.min.css" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="../../_layout/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
    <link href="../../_layout/css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="../../home/">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Home</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Accounts</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents">
            <li>
              <a href="./registered_accounts.php">Registered Accounts</a>
            </li>
            <li>
              <a href="./pending_registrations.php">Pending Registrations</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components2">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents2" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Photos</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents2">
            <li>
              <a href="./reported/">Reported Photos</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
    
  <?php if ($number_of_requests !== 0) { ?>
    
      <div class="content-wrapper">
        <div class="container-fluid">
          <!-- Icon Cards-->
          <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fa fa-fw fa-comments"></i>
                  </div>
                  <div class="mr-5"><?php echo $number_of_requests; ?> Registration Request(s)</div>
                </div>
              </div>
            </div>
          </div>
            
    <?php } ?>
            
    <?php if ($number_of_reports !== 0) { ?>

          <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fa fa-fw fa-comments"></i>
                  </div>
                  <div class="mr-5"><?php echo $number_of_reports; ?> Reported Photo(s)</div>
                </div>
              </div>
            </div>
          </div>
        
    <?php } ?>
            
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Picture Posting Activity</div>
        <div class="card-body">
          <canvas id="myAreaChart" width="100%" height="30"></canvas>
        </div>
        <div class="card-footer small text-muted">Updated at <?php echo $updatedAt ?></div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          </div>
        </div>
      </div>
      
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Acorn Academy</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    
    <!-- Bootstrap core JavaScript-->
    <script src="../../_layout/jquery/jquery.min.js"></script>
    <script src="../../_layout/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../_layout/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="../../_layout/chart.js/Chart.min.js"></script>
    <script src="../../_layout/datatables/jquery.dataTables.js"></script>
    <script src="../../_layout/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../_layout/js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="../../_layout/js/sb-admin-datatables.min.js"></script>
    <script src="../../_layout/js/sb-admin-charts.min.js"></script>
  </div>
</body>

</html>
