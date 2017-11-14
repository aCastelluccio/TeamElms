<?php
require_once __DIR__.'/vendor/autoload.php';

$file = new Google_Service_Drive_DriveFile();
$result = $service->files->insert($file, array(
  'data' => file_get_contents("C:\Users\Andrew\Documents\testImages\ahh - Copy (2).jpg"),
  'mimeType' => 'application/octet-stream',
  'uploadType' => 'media'
));
?>