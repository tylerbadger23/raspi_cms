<?php 
require "../config/config.php";
require "../config/authentication.php";

$file_error_arr = array("No Error","The uploaded file exceeds the upload_max_filesize directive", "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.", "The uploaded file was only partially uploaded." , " No file was uploaded.", " Failed to write file to disk.", " Failed to write file to disk." );

if(empty($_FILES['file'])) {
    $file = $_FILES['file'];
    print_r($file);
    $errorMsg = "Please choose a file with the correct format!";
    header("Location: ../index.php?emsg=$errorMsg");
    exit;
}

$maxLengthOfID = 12;
$file_id = generateUniqueID($maxLengthOfID);
$file_destination = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
$max_file_size = 5000000; //50mb
$file = $_FILES['file'];
$allowed_file_types = array("jpeg", "jpg", "png", "txt", "pdf","mp3","mp4","mov","css");
$video_types_arr = array('mp3','mp4','mov');
$img_file_arr = array('jpg','jpeg','png');
$humanFileType = "none";

$humanFileSize = formatBytes($_FILES['file']['size']);

$file_name = $file['name'];
$file_size = $file['size'];
$tmp_location = $file['tmp_name'];
$file_type_arr = explode("/", $file['type']);
$file_type;

if(isset($file_type_arr[1])) {
    $file_type = strtolower($file_type_arr[1]);
}
else {
    $file_type = strtolower($file_type_arr[0]);
}


$newFileName = $file_id . $file_name;
$target_file = "$file_destination" . "$newFileName";

$file_path_after = "uploads/" . $newFileName; 

if($file_type_arr[0] === "audio") {
    $humanFileType = "audio";
} else if($file_type_arr[0] === "image") {
    $humanFileType = "image";
} else if($file_type_arr[0] === "video"){
    $humanFileType = "video";
} else if($file_type_arr[0] === "application") {
    $humanFileType = "application";
} else if($file_type_arr[0] === "text"){
    $humanFileType = "text/media";
} else {
    $humanFileType = "other";
}

if($file_type_arr[0] == "video" || $file_type_arr[0] == "image" || $file_type_arr[0] == "audio") {
    $max_file_size = 2400000000;

} else {
    $max_file_size = 1000000000;
}

if($_FILES['file']['error'] > 0) {
    $errIndex = $_FILES['file']['error'];
    $errorCode =  $file_error_arr[$errIndex];
    $errorMsg = "There was an error uploading your file to our server! Make sure your file isnt too big and has a proper file type. Your error code was: $errorCode";
    header("Location: ../index.php?emsg=$errorMsg");
    exit;
}

if($file_size >= $max_file_size ) {
    $errorMsg = "Ths file you tried to upload was too big in size. File must be below 1GB. $file_size";
    header("Location: ../index.php?emsg=$errorMsg");
    exit;
}
$upload_date = date("Y-m-d H:i:s"); 
$username_washed = mysqli_real_escape_string($conn, $_POST['author_username']);

$sql_check = "SELECT id FROM users WHERE username='$username_washed'";
$user_results = mysqli_query($conn, $sql_check);
if(mysqli_num_rows($user_results) == 1  ) {

    //LAST CHANCE CHECKS
    if(!isset($humanFileType) || $humanFileType == "none") {
        $errorMsg = "Something went wrong uploading your file to our servers! $humanFileSize";
        header("Location: ../index.php?emsg=$errorMsg"); 
        exit;
    }
    $user = mysqli_fetch_row($user_results);
    $user_id = $user[0];
    $query = "INSERT INTO `uploads` (`id`, `author_username`, `author_id`,`upload_date`,`file_path`,`file_name`,`file_type`,`orig_name`,`file_size_user`,`file_size_bytes`) VALUES (NULL, '$username_washed', '$user_id','$upload_date','$file_path_after','$newFileName','$humanFileType','$file_name','$humanFileSize','$file_size')";


    //make sure user isnt over file save ammount
    $check_user_storager_query = "SELECT * FROM `user_defaults` WHERE user_id='$user_id'";
    $result_storage_check = mysqli_query($conn, $check_user_storager_query);

    $row = mysqli_fetch_row($result_storage_check);
    $storage_used = $row[5];
    $current_total_used = $storage_used + $file_size;

    $current_total_used_f = formatBytes($current_total_used);

    $update_defaults_query = "UPDATE `user_defaults` SET user_storage_used='$current_total_used_f', bytes_user_used='$current_total_used' WHERE user_id=$user_id";
    if(move_uploaded_file($tmp_location, $target_file) && mysqli_query($conn, $query) && mysqli_query($conn, $update_defaults_query)){
        $errorMsg = "Your file was successfully uploaded to our servers. $humanFileSize";
        header("Location: ../index.php?smsg=$errorMsg");
        exit;
    } else {  
        $errorMsg = "Something went wrong uploading your file to our servers. $humanFileType ";
        header("Location: ../index.php?emsg=$errorMsg");
        exit;
    }
}    // check if file is in allowed array
    function formatBytes($bytes, $precision = 2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    
        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 
    
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow]; 
    } 
