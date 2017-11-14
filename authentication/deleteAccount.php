<!DOCTYPE html>

<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("connect.php"); 
?>

<html>
    <head>
        <meta name="accountDeletion">
        <meta charset="utf-8">
        <title>Delete Account</title>
    </head>

    <body>
        <form method = "post" action = "<?php $_PHP_SELF ?>">
                  <table width = "400" border = "0" cellspacing = "1" 
                     cellpadding = "2">
                     
                     <tr>
                        <td width = "100">Account</td>
                        <td><input name = "account" type = "text" 
                           id = "account"></td>
                     </tr>
                     
                     <tr>
                        <td width = "100"> </td>
                        <td> </td>
                     </tr>
                     
                     <tr>
                        <td width = "100"> </td>
                        <td>
                           <input name = "delete" type = "submit" 
                              id = "delete" value = "Delete">
                        </td>
                     </tr>
                     
                  </table>
               </form>
    </body>
    
    <?php 
    
    $account = $_POST["account"];

//    echo $account . ' ';
//    var_dump(is_string($account));
    
    if (is_string($account)) {
        $id = mysqli_query($link, "SELECT id FROM `user` WHERE username = '$account'");
        $sqlResult = mysqli_fetch_assoc($id);
        $usrID = $sqlResult['id'];
        
        if (isset($_POST["delete"])) {
            mysqli_query($link, "DELETE FROM `user` WHERE  id = '$usrID'");
            mysqli_query($link, "DELETE FROM `account` WHERE  id = '$usrID'");
        }
    }
    
    ?>

</html>