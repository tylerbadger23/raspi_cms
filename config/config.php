<?php
session_start();

$user = 'root';
$password = 'root';
$db = 'personal_cloud';
$host = 'localhost';
$port = 8889;

$conn = new mysqli($host,$user,$password,$db,$port);

$file_name = $_SERVER['PHP_SELF'];

function displayTitle($s_self) {
$title = '';

switch ($s_self) {
    case "index.php":
        $title =  "Your Cloud Storage";
        break;
    case "login.php":
        $title =  "Access Your Personal Storage";
        break;
    case "register.php":
        $title = "Create Storage User";
        break;
    case "upload.php":
        $title =  "Upload Files to The Cloud";
        break;
    case "settings.php":
        $title =  "Customize Your Settings";
        break;
    case "account.php":
        $title = "View & Change Account Settings";
        break;
    }
    
    return $title;
}

?>