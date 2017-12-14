<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../../../vendor/phpauth/phpauth/Auth.php");
include("../../../vendor/phpauth/phpauth/Config.php");

$dbh = new PDO("mysql:host=xq7t6tasopo9xxbs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=py6etou4vck57kfy", "d2qpf22lyarz395l", "pejiin9edn8xmt5a") or die("Can't connect to database");
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config);

require_once("../../../vendor/autoload.php");

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

function deleteFile($drive, $fileId) {
  try { 
    $drive->files->delete($fileId);
  } catch (Exception $e) {
    print "An error occurred: " . $e->getMessage();
  }
}


$items = $_POST['checkbox'];

if (!isset($items)) {
    header('Location: ./');
    exit();
}

$drive = getDrive();
for ($i = 0;  $i < count($items); $i++) {
    if ($items[$i] === "Yes") {
        $images_path = $items[$i+1];
        
        deleteFile($drive, $images_path);
        
        $dbh->query("DELETE FROM images_tbl WHERE images_path = '$images_path'");
    }
}

header('Location: ./');
exit()

?>