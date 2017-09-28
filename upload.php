<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
//echo $target_file;
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "JPG" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";  
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
// Load the stamp and the photo to apply the watermark to
$stamp = imagecreatefrompng('acorn.png');
//if($imageFileType == "jpg" || $imageFileType == "JPG")

$im = imagecreatefromjpeg("uploads/" . basename( $_FILES["fileToUpload"]["name"]));
if(!$im){
    $im = imagecreatefrompng("uploads/" . basename( $_FILES["fileToUpload"]["name"]));
}
//if($imageFileType == "png"){
//    $im = imagecreatefrompng("uploads/" . basename( $_FILES["fileToUpload"]["name"]));
//}
$file_path = ("uploads/" . basename( $_FILES["fileToUpload"]["name"]));
if( !file_exists( $file_path ) ) { exit( 'file does not exists' );	}
// Set the margins for the stamp and get the height/width of the stamp image
$marge_right = 10;
$marge_bottom = 10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);

// Copy the stamp image onto our photo using the margin offsets and the photo 
// width to calculate positioning of the stamp. 
$exif = exif_read_data($file_path);
switch ($exif['Orientation']) {
        case 3:
        $image = imagerotate($im, 180, 0);
        break;
        case 6:
        $image = imagerotate($im, -90, 0);
        break;
        case 8:
        $image = imagerotate($im, 90, 0);
        break;
        default:
        $image = $im;
        break;
    } 
$src_w= imagesx($image);
$src_h= imagesy($image);
$dest_image = imagecreatetruecolor(500, 500); //targeted width and height
imagecopyresampled($dest_image, $image, 0, 0, 0, 0, 500, 500, $src_w, $src_h);
echo $dest_image;
imagecopy($dest_image, $stamp, imagesx($dest_image) - $sx - $marge_right, imagesy($dest_image) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
imagejpeg($dest_image, "uploads/" . $_FILES["fileToUpload"]["name"]);
// Free up memory
imagedestroy($image);
imagedestroy($dest_image);
$images = glob('uploads/' . '*.{gif,png,jpg,jpeg,JPG}', GLOB_BRACE); //formats to look for

    $num_of_files = 10; //number of images to display

    foreach($images as $image2)
    {
         $num_of_files--;
        

         if($num_of_files > -1) 
           echo "<b>".$image2."</b><br>Created on ".date('D, d M y H:i:s', filemtime($image2)) ."<br><img src="."'".$image2."'"."><br><br>" ; //display images
         else
           break;
    }
?>
