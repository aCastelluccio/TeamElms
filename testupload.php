<?php
echo __DIR__.'/vendor/autoload.php';
require_once __DIR__.'\vendor\google\apiclient\src\Google\Client.php';
require_once __DIR__.'\vendor\google\apiclient\src\Google\Service.php';
require_once __DIR__.'\vendor\autoload.php';

require_once __DIR__.'\vendor\google\apiclient-services\src\Google\Service\Drive.php';

$client = new Google_Client();
// Get your credentials from the console
$client->setClientId('1060065924858-b94sofn2u34i30j887hq5udsb1sd4tbr.apps.googleusercontent.com');
$client->setClientSecret('K6NBjcFIfzEkVuQRNnYGuXuq');
$client->setRedirectUri('http://localhost/testupload.php');
$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));

session_start();

if (isset($_GET['code']) || (isset($_SESSION['access_token']) && $_SESSION['access_token'])) {
    if (isset($_GET['code'])) {
        $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
    } else
        $client->setAccessToken($_SESSION['access_token']);

    $service = new Google_Service_Drive($client);

    //Insert a file
    $file = new Google_Service_Drive_DriveFile();
    $file->setName(uniqid().'.jpg');
    $file->setDescription('A test document');
    $file->setMimeType('image/jpeg');

    $data = file_get_contents('acorn2.jpg');

    $createdFile = $service->files->create($file, array(
          'data' => $data,
          'mimeType' => 'image/jpeg',
          'uploadType' => 'multipart'
        ));

    print_r($createdFile);

} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit();
}