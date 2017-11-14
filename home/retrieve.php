<div>
<?php
include("mysqlconnect.php");
include ("resize-class.php");

$query= "SELECT images_path FROM images_tbl";
$result= mysqli_query($link, $query) or die("error in $query == ----> ".mysqli_error());  
while($row = mysqli_fetch_array($result)){
//    echo $row ['images_path'];
//    $getImage= ['images_path'];
////
//    $resizeObj= new resize(['images_path'])
//    $resizeObj -> resizeImage(150, 150, 'crop');
//    echo "<img src='".$row[$resizeObj]."'/>";
    echo "<img src='".$row['images_path']."'/>";
    echo "\n";
}
?>
</div>

<div>
    <html>
        
        
        
        
        
        
    </html>
</div>


<div>
<form action="CamilleTestFile.html">
    <input type="submit" value="Submit Other Photo" />
</form>
</div>