<?php
include("mysqlconnect.php");





$query= "SELECT images_path FROM images_tbl";
$result= mysqli_query($link, $query) or die("error in $query == ----> ".mysqli_error());  
while($row = mysqli_fetch_array($result)){
    echo $row ['images_path'];
    echo "<img src='".$row['images_path']."' />";
}
?>