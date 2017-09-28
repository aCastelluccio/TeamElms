<?php
$images = glob('uploads/' . '*.{gif,png,jpg,jpeg}', GLOB_BRACE); //formats to look for

    $num_of_files = 4; //number of images to display

    foreach($images as $image)
    {
         $num_of_files--;

         if($num_of_files > -1) //this made me laugh when I wrote it
           echo "<b>".$image."</b><br>Created on ".date('D, d M y H:i:s', filemtime($image)) ."<br><img src="."'".$image."'"."><br><br>" ; //display images
         else
           break;
    }
?>