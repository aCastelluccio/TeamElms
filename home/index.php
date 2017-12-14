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

$_SESSION['emailPoster'] = "";

if (!isset($_SESSION['active_session']) || ($_SESSION['active_session'] === false)) { ?>
    <script text="text/javascript">
        alert("You must be logged in before you can visit this page.");
        window.location.href = '../account/';
    </script>
<?php 
} 
?>

<html lang="en">
<head>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css'>

  <head>

    <!-- Font -->
  <link href='https://fonts.googleapis.com/css?family=Dekko' rel='stylesheet'>

    <!-- CSS -->
    <style>

        @import url(https://fonts.googleapis.com/css?family=Lato:400,700);
        body {
            padding-top: 70px;
            background: #f2f2f2;
            font-family: Lato;
        }

        h1, h2 {
            font-size: 33px;
            color: white;
            padding-top: 10px;
            padding-right: 5px;
        }

        .starter-template {
            padding: 5px 5px;
            text-align: center;
        }

        .pagination {
            margin-bottom: 5px;
        }

        div {
            padding-top: 10px;
            margin: 0 auto;
        }

        div.transbox {
            margin-left: 250px;
            height: 150px;
            width: 600px;
            background-color: #e6e6e6;
            border: 2px dashed black;
        }

        .image-upload > input {
            display: none;
        }
        .image-upload img {
            width: 50px;
            cursor: pointer;
            margin-right: 100px;
            margin-top: 20px;
        }

        .button img {
            margin-right: -100px;
            margin-top: -120px;
        }

        .many p {
            margin-top: -50px;
        }

        .thumbnail img {
            background:transparent;
            padding:14px;
            border:2px solid #999999;
        }

      /* Create four equal columns that floats next to each other */
        .column {
            float: left;
            width: 25%;
            padding: 10px;
        }
        .col-md-5 img {
            margin-top: 12px;
            width: 100%;
        }
        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        /* Responsive layout - makes a two column-layout instead of four columns */
        @media (max-width: 800px) {
            .column {
                width: 50%;
            }
        }
        /* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
        @media (max-width: 600px) {
            .column {
                width: 100%;
           }
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

              <h1>Acorn</h1>
              <h2>Academy</h2>

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
                  <a class="nav-link" href="<?php if ($_SESSION['admin'] === true) { echo '../account/profile/'; } ?>"><?php if ($_SESSION['admin'] === true) { echo 'Profile'; } ?></a>
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

        <!-- Space -->
        <pre class="tab"> </pre>

        <!-- Page Heading -->
        <div style = "text-align: center" >

            <div class="background">

                <!-- Background Box -->
                <div class="transbox">

                    <style>
                        input.uploadinput {
                            margin-top: 45px;
                            margin-right: 100px;
                        }
                    </style>

                    <!-- Uploading An Image -->
                    <form method="post" enctype="multipart/form-data" >

                        <!-- ORIGINAL 'CHOOSING FILES' BUTTON -->
                        <input class="uploadinput" for="uploadedimage[]" type="file" name="uploadedimage[]" multiple>

<!--
                        <div class="image-upload">
                        <label>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Ic_attach_file_48px.svg/120px-Ic_attach_file_48px.svg.png"/>
                        </label>
                        </div>
-->

<!--
                        <div class="image-upload">
                            <label for="file-input">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Ic_attach_file_48px.svg/120px-Ic_attach_file_48px.svg.png"/>
                            </label>

                            <input id="file-input" type="file"/>
                        </div>

-->

                        <div class="button">
                            <!-- Upload Button Image -->
                            <button type="submit" style="background-color:transparent; border-color:transparent;">
                                <img src="http://simpleicon.com/wp-content/uploads/cloud-upload-1.png" height="60" margin-top: 400px/>
                            </button>
                        </div>

                        <div class="many">
                            <!-- More Than 20 Images Upload-->
                            <p><a href="https://drive.google.com/drive/u/1/folders/0B0Uz_T5t_1jOaWMyNmh5UURaaDQ">
                                <?php if ($_SESSION['admin'] === true) { echo 'If you are uploading more than 20 images, upload them directly here'; } ?></a></p>
                        </div>
                         <!-- Space -->
                        <pre class="tab"> </pre>

                    </form>

                </div>
            </div>

        <?php
        function refreshDataBaseFromDrive($driveService, $folderId,$link) {
          $pageToken = null;
          $response = $driveService->files->listFiles(array(
            'q' => "'1060dPAJ7b2q1haJSQvwPjCzshDQRUfbB' in parents and trashed = false",
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

          $result = mysqli_query($link, $query);
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
            $client->setClientId('1032449672696-e2n625h5ubahbapa6lkcpm32chgjlvs5.apps.googleusercontent.com');
            $client->setClientSecret('lnRveJrKlA8TnhgBq5gqK0Fb');
            $client->setApprovalPrompt('auto');
            $client->setAccessType('online');
            $client->getAccessToken('ya29.GlsiBWv9h15VC_wM71t8ZFtD9ZXzAQ2HKAik0nUEUHbklyrEkhK7wsZrRw5EDtGUA4fgrMtIePcVEXFgW_sr5OG67pCmkDUv7SCGLzaDasN2o3BYASAyzOxPZ0J0');
            $client->refreshToken('1/hYph71pGWjL6JfqzQE57i5_vQqemlum7AgOuJrDmvBQ');
            return $client;
        }

        function gDrive() {
            $client = getClient();
            $client->addScope(Google_Service_Drive::DRIVE);
            $drive = new Google_Service_Drive($client);
            return $drive;
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

        $drive = gDrive();
        $folderId = '1060dPAJ7b2q1haJSQvwPjCzshDQRUfbB';

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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-lazyload/10.3.5/lazyload.min.js"></script>
  <script text="text/javascript"> var myLazyLoad = new LazyLoad(); </script>

            <!-- Adds The Images -->
              <div class="row">
                <div class="col-md-5">
                    <div class="thumbnail">
                  <a>
                    <img name="picture" class="img-fluid rounded mb-3 mb-md-0" data-src="https://drive.google.com/uc?export=view&id=<?php echo $row['images_path']; ?>" height="50%" width="50%" >
                      <div class="caption">
                        <div id="some-div">
                        <p><?php echo $first . ' ' . $last; ?></p>
                            <span id="some-element">

                                    <!-- BUTTONS: REPORT & EMAIL -->
                                  <form action="action_to_do.php" method="post">
                                      <button name="emailPoster" type="submit" value="<?php echo $row['images_path']; ?>" <?php if ($first === 'Default') { echo 'disabled'; } ?>>Email <?php echo $first; ?></button>
                                      <button name="reportPhoto" type="submit" value="<?php echo $row['images_path']; ?>" <?php if ($first === 'Default') { echo 'disabled'; } ?>>Report This Photo</button>
                                  </form>


                                   <!-- Space -->
<!--                                  <pre class="tab"> </pre>-->

                                <!-- ADD A COMMENT -->
<!--
                                <div class="warning" id="no_go"></div>
                                <div class="commentbox-app">
                                  <div class="container">
                                    <div class="clearfix">
                                      <form id="comment-form">
                                        <input type="text" id="comment-input" class="comment-input" placeholder="Comment...">
                                        <input type="submit" value="Post" class="comment-btn">
                                      </form>
                                    </div>
                                    <p id="comment-stream" class="comment-stream"> </p>
                                    <button class="remove-all-btn" id="remove-all" type="button">Remove all</button>
                                  </div>
                                </div>
-->


                                <!-- ACTUALLY ADDING A COMMENT -->
                                <script>
                                function reportPhoto() {
                                    alert("<?php echo $row['images_path']; ?>");
                                    <?php
                                    $picture = $row['images_path'];
                                    $success = $dbh->query("UPDATE images_tbl SET reported=1 WHERE images_path = $picture");
                                    ?>
                                }
                                function hideWarning() {
                                  document.getElementById('no_go').style.display = 'none';
                                }
                                function showWarning () {
                                  document.getElementById('no_go').style.display = 'block';
                                  document.getElementById('no_go').innerHTML = '<strong>Warning:</strong> App will not work if local storage is disabled or unsupported.';
                                  console.warn('App will not work if local storage is disabled or unsupported.');
                                }
                                function supportsLocalStorage () {
                                  return typeof localStorage !== 'undefined';
                                }
                                function getComments() {
                                  return JSON.parse(localStorage.getItem('comments')) || [];
                                }
                                function saveComment (comments, commentStr, action) {
                                  if (!commentStr && comments.indexOf(commentStr) < 0) {
                                    action(err);
                                  }
                                  action(undefined, commentStr);
                                }
                                function appendToStream(stream, str, index) {
                                  var div = document.createElement('div');
                                  div.setAttribute('data-index', index);
                                  div.innerHTML = str;
                                  stream.appendChild(div);
                                }
                                function loadComments(stream) {
                                  var comments = getComments();
                                  if (comments) {
                                    for (var i = 0; i < comments.length; i++) {
                                      appendToStream(stream, comments[i], i);
                                    }
                                  }
                                }
                                function clearComments(stream) {
                                  localStorage.removeItem('comments');
                                  stream.innerHTML = '';
                                }
                                if (supportsLocalStorage()) {
                                  initApp();
                                } else {
                                  showWarning();
                                }
                                function initApp() {
                                  hideWarning();
                                  var commentForm = document.getElementById('comment-form'),
                                      commentList = document.getElementById('comment-stream'),
                                      commentInput = document.getElementById('comment-input'),
                                      removeAll = document.getElementById('remove-all');
                                  loadComments(commentList);
                                  removeAll.addEventListener('click', function() {
                                    clearComments(commentList);
                                  }, true);
                                  commentForm.addEventListener('submit', function (event) {
                                    event.preventDefault();
                                    var commStr = commentInput.value,
                                        comments = getComments();
                                    saveComment(comments, commStr, function(err, value) {
                                      if (err) {
                                        return;
                                      }
                                      comments.push(value);
                                      localStorage.setItem('comments', JSON.stringify(comments));
                                      appendToStream(commentList, commStr);
                                      commentInput.value = '';
                                    });
                                  }, true);
                                }
                                </script>

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
                                      margin-bottom: 15px;
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
