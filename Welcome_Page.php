<!DOCTYPE html>
<?php 
//TO-DO: if not logged in, then redirect to login.html
session_start(); 
if ($_SESSION['logged_in'] == 0) {
    header('Location: ./authentication/tempHome.html');
    exit();
}
?>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome Page</title>
  
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
    <meta name="description" content="">
    <meta name="author" content="">

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
              <a class="nav-link" href="#">Home
                <span class="sr-only"></span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Favorites</a>
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
                    
                    
          <input type="file" name="uploadedimage">
          <input type="submit" value="Upload Image" enctype="multipart/form-data">

        </form>

    <?php
          
         ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    include("mysqlconnect.php");
    include ("resize-class.php");
        function 
            GetImageExtension($imagetype)
        {
           if(empty($imagetype)) return false;
           switch($imagetype)
           {
               case 'image/bmp': return '.bmp';
               case 'image/gif': return '.gif';
               case 'image/jpeg': return '.jpg';
               case 'image/png': return '.png';
               default: return false;
           }
         }

    if (!empty($_FILES["uploadedimage"]["name"])) {
        $file_name=$_FILES["uploadedimage"]["name"];
        $temp_name=$_FILES["uploadedimage"]["tmp_name"];
        $imgtype=$_FILES["uploadedimage"]["type"];
        $ext= GetImageExtension($imgtype);
        $imagename=date("d-m-Y")."-".time().$ext;
        $target_path = "images/".$imagename; 
//        $marge_right = 10;
//        $marge_bottom = 10;
//        $stamp = imagecreatefrompng('acorn.png');
//
//        $sx = imagesx($stamp);
//        $sy = imagesy($stamp);
        if(move_uploaded_file($temp_name, $target_path)) {   
//            $query_upload="INSERT INTO images_tbl(images_path, submission_date) VALUES ('".$target_path."','".date("Y-m-d")."')";
//            mysqli_query($link, $query_upload) or die("error in $query_upload == ----> ".mysqli_error());
//            if $imagetype ==""
//            $im = imagecreatefromjpeg($target_path);
//            if(!$im){
//                $im = imagecreatefrompng($target_path);
//            }
//            imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
//            imagejpeg($im, $target_path);

        } else {
            exit("Error While uploading image on the server");
        }
        require_once __DIR__.'/vendor/autoload.php';

        session_start();
        
        $client = new Google_Client();
        $client->setAuthConfig('client_secrets.json');
        $client->addScope(Google_Service_Drive::DRIVE);

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
          $client->setAccessToken($_SESSION['access_token']);
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
        //printf("File ID: %s\n", $file->id);
        
            $query_upload="INSERT INTO images_tbl(images_path, submission_date) VALUES ('".$file->id."','".date("Y-m-d")."')";
            mysqli_query($link, $query_upload) or die("error in $query_upload == ----> ".mysqli_error());
        } else {
          $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
          header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
          }
    }
    //echo '<meta http-equiv="refresh" content="0; URL=retrieve.php" />';
    ?>     
   


    <!-- Space -->
    <pre class="tab"> </pre>
   
          
      <!-- Project One -->
    <?php 
          include("mysqlconnect.php");
          $query= "SELECT images_path FROM images_tbl";
          $result= mysqli_query($link, $query) or die("error in $query == ----> ".mysqli_error()); 
          while($row = mysqli_fetch_array($result)){
          ?>
          
          <!-- for adding pages, add a counter: when hits certain num, point to next page -->
          
      <div class="row">
        <div class="col-md-7">
          <a href="#">
            
            <img class="img-fluid rounded mb-3 mb-md-0" src="https://drive.google.com/uc?export=view&id=<?php echo $row['images_path'];?>" alt="">
          </a>
        </div>
        <div class="col-md-5">
          <p>comment</p>
          
        </div>
      </div>
        <?php }?>

      <!-- Pagination -->
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">3</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  </body>

