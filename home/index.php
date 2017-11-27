<!DOCTYPE html>
<?php
//TO-DO: if not logged in, then redirect to index.html
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("mysqlconnect.php");
include ("resize-class.php");
include("../account/authconnect.php");
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
          <p><a href="https://drive.google.com/drive/u/1/folders/0B0Uz_T5t_1jOaWMyNmh5UURaaDQ">
            If you are uploading more than 20 images, upload them directly here</a></p>
        </form>

        <?php

        function refreshDataBaseFromDrive($driveService, $folderId,$link) {
          $pageToken = null;

          $response = $driveService->files->listFiles(array(
            'q' => "'0B0Uz_T5t_1jOaWMyNmh5UURaaDQ' in parents and trashed = false",
            'spaces' => 'drive',
            'pageToken' => $pageToken,
            'fields' => 'nextPageToken, files(id, name)',
          ));
          foreach ($response->files as $file) {
            $query="SELECT images_path FROM images_tbl ORDER BY images_id DESC";


            $result = mysqli_query($link, $query) or die("error in $query == ----> ".mysqli_error());
            $found = false;
            while($row = mysqli_fetch_array($result)){
              if ($row['images_path'] == $file->id)
              $found = true;

            }
            if (!$found){
              $query_upload="INSERT INTO images_tbl(images_path, submission_date) VALUES ('".$file->id."','".date("Y-m-d")."')";
              mysqli_query($link, $query_upload) or die("Error: #1");
            }
          }
          $result = mysqli_query($link, $query) or die("error in $query == ----> ".mysqli_error());

          while($row = mysqli_fetch_array($result)){
            $found = false;
            foreach ($response->files as $file) {
              if ($row['images_path'] == $file->id)
              $found = true;

            }
            if(!$found){
              $query_delete="DELETE FROM images_tbl WHERE images_path = '$row[images_path]'";
              mysqli_query($link, $query_delete) or die("Error: #1");

            }

          }
        }

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
        $client = getClient();
        $client->addScope(Google_Service_Drive::DRIVE);
        $drive = new Google_Service_Drive($client);
        $folderId = '0B0Uz_T5t_1jOaWMyNmh5UURaaDQ';

        refreshDataBaseFromDrive($drive,$folderId,$link);

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

              $query_upload="INSERT INTO images_tbl(poster_email, images_path, submission_date) VALUES ('".$_SESSION['email']."','".$file->id."','".date("Y-m-d")."')";
              mysqli_query($link, $query_upload) or die("Error: #1");?>

              <script text="text/javascript">
                  window.location.href = "./confirm.php";
              </script>

          <?php } 
        }
          
        function reportPhoto() {
            $reportButton = $_POST['reportButton'];
            $photo = $_POST['photoToReport'];
            
            if (isset($reportButton)) {
                $sth = $dbh->prepare("UPDATE images_tbl SET reported=1 WHERE images_path = $photo");
                $sth->execute();
            }
        }

      ?>

    <!-- Space -->
    <pre class="tab"> </pre>

      <!-- Project One -->
    <?php
          //getting an image
          $query = "SELECT images_path FROM images_tbl ORDER BY images_id DESC";
          $result = mysqli_query($link, $query) or die("error in $query == ----> ".mysqli_error());

          while($row = mysqli_fetch_array($result)){

          //getting image's id based on the image's path
          $imgPx = $row['images_path'];
          $imgP = mysqli_query($link, "SELECT images_id FROM images_tbl WHERE images_path = '$imgPx'") or die("There was a problem getting the image's id");
          $imgID = $imgP->fetch_assoc()['images_id'];

          //getting poster's email based on the image id
          $posterEmailQuery = "SELECT poster_email FROM images_tbl WHERE images_id = $imgID";
          $result2 = mysqli_query($link, $posterEmailQuery) or die("There was a problem getting the email of the user who posted the image");
          $posterEmail = $result2->fetch_assoc()['poster_email'];

          //getting the first and last name based on the poster's email
          $displayUID = $auth->getUID($posterEmail);
          $firstResult = mysqli_query($link, "SELECT first_name FROM user_info WHERE uid = $displayUID");
          $lastResult = mysqli_query($link, "SELECT last_name FROM user_info WHERE uid = $displayUID");
          $first = $firstResult->fetch_assoc()['first_name'];
          $last = $lastResult->fetch_assoc()['last_name'];

    ?>

          <!-- for adding pages, add a counter: when hits certain num, point to next page -->


  <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-lazyload/10.3.5/lazyload.min.js"></script>
  <script text="text/javascript"> var myLazyLoad = new LazyLoad(); </script>
      <div class="row">
        <div class="col-md-5">
            <div class="thumbnail">
          <a>
            <img name="photoToReport" class="img-fluid rounded mb-3 mb-md-0" data-src="https://drive.google.com/uc?export=view&id=<?php
            echo $row['images_path'];?>" alt="" height="50%" width="50%" >
              <div class="caption">
                <div id="some-div">
                <p><?php echo $first . ' ' . $last; ?></p>
                    <span id="some-element"> 
                        
                            <!-- BUTTONS: REPORT & EMAIL -->
                          <form method="post">
                              <button type="submit">Email <?php echo $first ?></button>
                              <button name="reportButton" type="submit">Report This Photo</button>
                          </form>

                           <!-- Space -->
                          <pre class="tab"> </pre>

                          <!-- PLACEHOLDER COMMENTS -->
                          <p> comments </p>
                          <p> comments </p>
                          <p> comments </p>
                          <p> comments </p>
                          <p> comments </p>

                          <!-- ADD A COMMENT -->
                          <form action="/action_page.php" method="get">
                              <input type="text" name="lname" placeholder="write a comment..."><br>
                              <button class="commentbutton" type="submit">Submit Comment</button>
                          </form>
                      </span>
                  </div>
                  <div>
                      <style>
                          button.commentbutton {
                              margin-top: 10px;
                          }
                          #some-element {
                              border: 1px solid #ccc;
                              display: none;
                              font-size: 15px;
                              margin-top: 15px;
                              padding: 15px;
                          }

                          #some-div:hover #some-element {
                              display: block;
                          }
                      </style>
                  </div>
              </div>
          </a>

        </div>
      </div>
          <br>
          </div>
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
