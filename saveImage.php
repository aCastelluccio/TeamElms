
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("mysqlconnect.php");
echo $conn;
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
	
if(move_uploaded_file($temp_name, $target_path)) {

 	#$query_upload="INSERT INTO images_tbl(images_path, submission_date) VALUES ('".$target_path."','".date("Y-m-d")."')";
    $query_upload="INSERT INTO images_tbl(images_path, submission_date) VALUES ('".$target_path."','".date("Y-m-d")."')";
    
    
	mysqli_query($link, $query_upload) or die("error in $query_upload == ----> ".mysqli_error()); 
    
	
}else{

   exit("Error While uploading image on the server");
}

}
echo '<meta http-equiv="refresh" content="0; URL=retrieve.php" />';

?>
