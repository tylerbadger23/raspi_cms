<?php
require "../config/config.php";
if(isset($_POST['file_id']) && strlen($_POST['file_id']) >= 10) { // check length of id in url to make sure its un tamered in length /format
    //still need to check data before entering it into database 
    //TODO filter all data still un-done

    $unique_id = mysqli_real_escape_string($conn, $_POST['file_id']);
    $id = mysqli_real_escape_string($conn, $_POST['real_id']);
    echo($unique_id);

    

    $delete_with_id = "DELETE FROM `files` WHERE `id` = '$id' AND `unique_id` = '$unique_id'";
    if(mysqli_query($conn, $delete_with_id)) {
        $successMsg = "Your file was successfully deleted";
        header("Location: ../index.php?filedel=$successMsg");
        exit;
    } else {
        $errorMsg = "Could not delete the file you requested. Please try again later.";
        header("Location: ../file.php?id=$file_id&error=$errorMsg");
        exit;
    }

} else if(isset($_POST['file_id']) || $_POST['file_id'] == false || $_POST['real_id'] == false) {
    $successMsg = "Your file was successfully deleted";
    header("Location: ../index.php?filedel=$successMsg"); 
    exit;
} else {
    $errorMsg = "Could not delete the file you requested. Please try again later.";
    header("Location: ../file.php?id=$file_id&error=$errorMsg");
    exit;
}
