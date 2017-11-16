<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Admin Page - Pending Registrations</title>
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
    <a class="navbar-brand" href="./adminpage.php">Admin Dashboard</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
    
    <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Account Registration Requests</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Request Date</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Kent Harris</td>
                  <td>email@yahoo.com</td>
                  <td>11/16/2017</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
    
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
</body>
</html>