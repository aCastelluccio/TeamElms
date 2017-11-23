<!DOCTYPE html>

<?php
//TO-DO: if not logged in, then redirect to index.html
session_start();
ini_set('post_max_size', '10000M');
ini_set('upload_max_filesize', '10000M');
ini_set('max_file_uploads', '2000');
ini_set('max_execution_time', '2000');
ini_set('max_input_time', '2000');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("mysqlconnect.php");
include ("resize-class.php");
require_once __DIR__.'../../vendor/autoload.php';

if (!isset($_SESSION['active_session']) || ($_SESSION['active_session'] === false)) { ?>
    <script text="text/javascript">
        alert("You must be logged in before you can visit this page.");
        window.location.href = '../account/';
    </script>
<?php } ?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Acorn Academy</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css'>

    <head>

    <!-- Font -->
  <link href='https://fonts.googleapis.com/css?family=Dekko' rel='stylesheet'>

    <!-- CSS -->
    <style>

       body {
      padding-top: 70px;
      font-family: 'Dekko';
      }

      h1 { font-size: 80px; }
      h2 { font-size: 30px; }

      .starter-template {
      padding: 5px 5px;
      text-align: center;
      }

      .pagination {
        margin-bottom: 5px;
      }

  </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="home_page">
    <meta name="author" content="teamelms">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/1-col-portfolio.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="./">Home
                <span class="sr-only"></span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./about/">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./favorites/">Favorites</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../account/profile/">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../account/logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <!-- Page Heading -->
      <div style = "text-align: center" >
      <h1 class="my-4">Acorn Academy</h1>


       <!-- Uploading An Image -->
        <form method="post" enctype="multipart/form-data" >


          <input type="file" name="uploadedimage[]" multiple>
          <input type="submit" value="Upload Image" enctype="multipart/form-data">

        </form>

        <?php

         function getClient(){
            $client = new Google_Client();
            $client->setClientId('1060065924858-b94sofn2u34i30j887hq5udsb1sd4tbr.apps.googleusercontent.com');
            $client->setClientSecret('K6NBjcFIfzEkVuQRNnYGuXuq');
            $client->setApprovalPrompt('auto');
            $client->setAccessType('online');
            $client->getAccessToken('ya29.GlvsBF_2sD_Bn9ioOzePSiOgEJC2NiLZ2HbG1LTclPAv3h7sGDWsjlTgJ8vaVdgSuf2_wvLz88Lj7CC6Y9oWkEpAbQEzdqmZwdoM_XXO9QOkb67giNzgMVoqeKIq');
            $client->refreshToken('1/mZ9Ja7eNiQFrCJbETDKuYCiiPo2qppWYABYi5oTPXv0');
            return $client;
        }

        function GetImageExtension($imagetype) {
           if(empty($imagetype)) return false;

           switch($imagetype) {
               case 'image/bmp': return '.bmp';
               case 'image/gif': return '.gif';
               case 'image/jpeg': return '.jpg';
               case 'image/png': return '.png';
               default: return false;
           }
        }

        if (!empty($_FILES["uploadedimage"])) {
            $myFile = $_FILES['uploadedimage'];
            $file_count = count($myFile["name"]);
            for ($i = 0; $i < $file_count; $i++) {
              $temp_name = $myFile["tmp_name"][$i];
              $imgtype = $myFile["type"][$i];
              $ext = GetImageExtension($imgtype);
              $imagename = date("d-m-Y")."-".$myFile["name"][$i];
              $target_path = "../images/".$imagename;

              if(move_uploaded_file($temp_name, $target_path)) {

              } else {
                  exit("Error While uploading image on the server");
              }

              $client = getClient();
              $client->addScope(Google_Service_Drive::DRIVE);
              $drive = new Google_Service_Drive($client);
              $folderId = '0B0Uz_T5t_1jOaWMyNmh5UURaaDQ';

              $fileMetadata = new Google_Service_Drive_DriveFile(array(
                  'name' => $target_path,
                  'parents' => array($folderId)
              ));

              $content = file_get_contents($target_path);
              $file = $drive->files->create($fileMetadata, array(
                  'data' => $content,
                  'mimeType' => 'image/jpeg',
                  'uploadType' => 'multipart',
                  'fields' => 'id'));

              $query_upload="INSERT INTO images_tbl(images_path, submission_date) VALUES ('".$file->id."','".date("Y-m-d")."')";
              mysqli_query($link, $query_upload) or die("Error: #1"); ?>

              <script text="text/javascript">
                  window.location.href = "./confirm.php";
              </script>
        <?php } }

    ?>



    <!-- Space -->
    <pre class="tab"> </pre>


      <!-- Project One -->
    <?php
          $query = "SELECT images_path FROM images_tbl ORDER BY images_id DESC";
          $result = mysqli_query($link, $query) or die("error in $query == ----> ".mysqli_error());

          while($row = mysqli_fetch_array($result)){ ?>

          <!-- for adding pages, add a counter: when hits certain num, point to next page -->

      <div class="row">
        <div class="col-md-7">
          <a href="#">
            <img class="img-fluid rounded mb-3 mb-md-0" src="https://drive.google.com/uc?export=view&id=<?php
            echo $row['images_path'];?> "alt="" height="50%" width="50%" >

          </a>

        </div>

        <div class="col-md-5">
          <p>comment</p>

        </div>
      </div>
          <br>
        <?php } ?>

    </div>

    <!-- /.container -->

    <!-- Footer -->
<!--
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Acorn Academy 2017</p>
      </div>
       /.container
    </footer>
-->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

      </div>
         <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Acorn Academy 2017</p>
      </div>
      <!-- /.container -->
    </footer>
</body>
</head>
</html>
