<?php
require "../config/authentication.php";
require "../config/config.php";

$maxLengthOfID = 10; // max lengtyh set in mysqli db for unique id

$username = mysqli_real_escape_string($conn, $_POST['username']);
$filename = mysqli_real_escape_string($conn, $_POST['file_name']);
$file_contents = mysqli_real_escape_string($conn, $_POST['file_contents']);
//check if file has id before proceeding in saving
    //if file has if then save file to that id
    //if file doesnot have id and is set to true then create new fle in database

$filename = mysqli_real_escape_string($conn, $_POST['file_name']);
$timestamp = date("Y-m-d H:i:s");  
if($_POST['file_id'] == "false" ) {
    $unique_id = generateUniqueID($maxLengthOfID); // generate completely unique id .function is in authentication class

    $create_query = "INSERT INTO `files` (`id`, `filename`, `author_un`,`contents`,`unique_id`,`timestamp`) VALUES (NULL, '$filename', '$username','$file_contents','$unique_id','$timestamp')";
    if(mysqli_query($conn, $create_query)){ // if query is successfull then save file then if not display errror
        $errorMsg = "File was saved completely";
        header("Location: ../file.php?id=$unique_id");
        exit;
    } else {
        echo($create_query);
        $errorMsg = "File could not be saved to the database. Please try again";
        header("Location: ../index.php?error=$errorMsg");
        exit;
    }
    
} else if(strlen($_POST['file_id']) >= $maxLengthOfID) {
    $unique_id = mysqli_real_escape_string($conn, $_POST['file_id']);

    $update_query = "UPDATE `files` SET `filename` = '$filename', `contents` = '$file_contents' WHERE `unique_id` = '$unique_id'";
    if(mysqli_query($conn, $update_query)) { // if query is successfull then save file then if not display errror
        $errorMsg = "File was saved completely";
        header("Location: ../file.php?id=$unique_id");
        exit;
    } else {
        $errorMsg = "This file could not be saved to the database. Something went wrong.";
        header("Location: ../index.php?error=$errorMsg");
        exit;
    }
} else {
    echo(strlen($_POST['file_id']));
    $errorMsg = "Something went wrong trying to save your file. Try again later";
    header("Location: ../index.php?error=$errorMsg");
    exit;
}
