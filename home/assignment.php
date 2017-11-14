<html>
<head><title>Input Test</title></head>
<body>
  <form method="post" action="">
    <input type="text" name="something" value="" />
    <input type="submit" name="submit" />
  </form>

<?php
if(isset($_POST['submit'])) {
  $submission = htmlspecialchars($_POST['something']);
}
?>
</body>
<html>

<html>
<head><title>DB Test</title></head>
<body>
<?php
$sqlHost = 'localhost';
$sqlUser = 'user';
$sqlPass = 'CSCI330';
$dbName = 'Movies';

$db =  new mysqli($sqlHost, $sqlUser, $sqlPass, $dbName) ;

if($db->connect_errno){
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}
     
$result = $db->query("SELECT film.film_id, film.title, film.release_year, film.rating, category.name FROM film

JOIN film_category ON film_category.film_id = film.film_id

JOIN category ON category.category_id = film_category.category_id

WHERE film.title LIKE '%$submission%';")
    or trigger_error($db->error);
var_dump($result);?>
<TABLE>
<TR>
<TH>Film Id</TH>
<TH>Title</TH>
<TH>Release<BR>Year</TH>
<TH>Rating</TH>
<TH>Genre</TH>
</TR>
<?php
$array = array('film_id', 'title', 'release_year', 'rating', 'name');
while($row = $result->fetch_array()) {
    // Less DRY ways to display for testing
    //echo var_dump($row);
    //echo $row['film_id'].": ".$row['title']." (".$row['release_year'].", ".$row['rating'].")";
    //echo "<BR>";
    echo "<TR>";
    foreach($array as $field) { 
        echo "<TD>".$row[$field]."</TD>";
    }
    echo "</TR>";
}
$db->close();
 ?> 
</TABLE>
 </body>
</html>