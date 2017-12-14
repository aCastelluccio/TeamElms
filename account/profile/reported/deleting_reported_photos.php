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
            $client->setClientId('1060065924858-b94sofn2u34i30j887hq5udsb1sd4tbr.apps.googleusercontent.com');
            $client->setClientSecret('K6NBjcFIfzEkVuQRNnYGuXuq');
            $client->setApprovalPrompt('auto');
            $client->setAccessType('online');
            $client->getAccessToken('ya29.GlvsBF_2sD_Bn9ioOzePSiOgEJC2NiLZ2HbG1LTclPAv3h7sGDWsjlTgJ8vaVdgSuf2_wvLz88Lj7CC6Y9oWkEpAbQEzdqmZwdoM_XXO9QOkb67giNzgMVoqeKIq');
            $client->refreshToken('1/mZ9Ja7eNiQFrCJbETDKuYCiiPo2qppWYABYi5oTPXv0');
            return $client;
}
        
function getDrive() {
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