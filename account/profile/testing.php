<!DOCTYPE html>
<?php 

require("../../vendor/phpauth/phpauth/Auth.php");
include("../../vendor/phpauth/phpauth/Config.php");

$dbh = new PDO("mysql:host=xq7t6tasopo9xxbs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=py6etou4vck57kfy", "d2qpf22lyarz395l", "pejiin9edn8xmt5a") or die("Can't connect to database");
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config);

//change to select people from user_info that aren't approved, add to this table, and then do the rest
$sth = $dbh->prepare("SELECT * FROM pending_registration_requests");
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);

$arrayCount = count($result);
$count1 = 0;
$updatedAt = date('m-d-Y H:i');

?>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
            <form method="post">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Request Date</th>
                  <th>Approve?</th>
                </tr>
              </thead>
              <tbody> <?php
                while ($count1 < $arrayCount) { ?>
                    <tr>
                      <td><?php echo $result[$count1]['first_name'] . ' ' . $result[$count1]['last_name'] ?></td>
                      <td><input id="cbemail<?php echo $count1 ?>" name="cbemail<?php echo $count1 ?>" value="<?php echo $result[$count1]['email'] ?>" readonly/></td>
                      <td><?php echo $result[$count1]['dt'] ?></td>
                      <td>
                          <div>
                              <label>
                                <input type="checkbox" class="radio" id="checkbox<?php echo $count1; ?>" value="Yes" name="checkbox<?php echo $count1; ?>"/>Yes</label>
                              <label>
                                <input type="checkbox" class="radio" id="checkbox<?php echo $count1; ?>" value="No" name="checkbox<?php echo $count1; ?>"/>No</label>
                          </div>
                      </td>
                    </tr> <?php
                $count1 += 1;    
                }
                ?>
              </tbody>
            </table>
                
            <script text="text/javascript">
                var indexOf = [];
                $("input:checkbox").on('click', function() {
                  // in the handler, 'this' refers to the box clicked on
                  var $box = $(this);
                  if ($box.is(":checked")) {
                    // the name of the box is retrieved using the .attr() method
                    // as it is assumed and expected to be immutable
                    var group = "input:checkbox[name='" + $box.attr("name") + "']";
                    // the checked state of the group/box on the other hand will change
                    // and the current value is retrieved using .prop() method
                    $(group).prop("checked", false);
                    $box.prop("checked", true);
                    indexOf.push($(this).closest('tr').index() + 1); //Solve problem where if you check a checkbox and then change                                                      it to the other option, it still adds the initially checked                                                        option
                  } else {
                    $box.prop("checked", false);
                    indexOf.pop($(this).closest('tr').index() + 1);
                  }
                });
                 
               function test() {
                    <?php 
                        $dom = new DOMDocument();
                        $dom->load("testing.php");
                        $divs = $dom->getElementsByTagName('td'); ?>
                        alert("<?php var_dump($divs); ?>");
                        <?php 
                        foreach ($divs as $div) {
                            foreach ($div->attributes as $attr) {
                              $name = $attr->nodeName;
                              $value = $attr->nodeValue; ?>
                              alert("<?php echo "Attribute " . " "  ?>");
                            <?php }
                        }
                    ?>
                }
                
            </script>
                <button id="confirmButton" name="confirmButton" type="submit" onclick="test();">Confirm</button>
          </form>
          </div>
        </div>
        <div class="card-footer small text-muted">Updated <?php echo $updatedAt; ?></div>
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