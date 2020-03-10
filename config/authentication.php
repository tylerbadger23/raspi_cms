<?php

function checkUser($redirectToFile, $errorMsg,$conn) { //checks session for user returns true is true false if false
    if(isset($_SESSION['username'])){
        $username_washed = mysqli_real_escape_string($conn, $_SESSION['username']);

        $sql_check = "SELECT * FROM users WHERE username='$username_washed'";
        $results = mysqli_query($conn, $sql_check);
        if(mysqli_num_rows($results) == 1  ){
            return true;
        } else {
            header("Location: ./login.php?r=$errorMsg&rp=$redirectToFile");
            exit;
        }
    } else {
        header("Location: ./login.php?r=$errorMsg&rp=$redirectToFile");
        exit;
    }
}
    
function generateUniqueID($requiredLength) {
    $rand_str = uniqid();
    //required length will be set in paramaters

    while (strlen($rand_str) < $requiredLength) {
        $rand_ints = rand(0, 9);
        $rand_str = $rand_str . $rand_ints;
    }

    return $rand_str;
}


function showShortString($string, $maxLength) {
    $shortString; // function used to show x length of origial string
    if(strlen($string) > $maxLength) { // if string is longer than wanted max length then shorten else leave and return string failed
        $modified_string = substr($string, 0, $maxLength);
        $shortString = $modified_string . "...";
        return $shortString;
        exit;
    } else if(strlen($string) <= $maxLength) {
        $shortString = $string;
        return $shortString;
        exit;
    }else {
        return $string;
        exit;
    }
}

function getFilesFromUser($username,$conn) {
    $select_query = "SELECT * FROM `files` WHERE author_un='$username'";
    $results = mysqli_query($conn, $select_query);

    return $results;
}

function getUploadsFromUser($username, $conn) {
    $select_query = "SELECT * FROM `uploads` WHERE author_username='$username'";
    $results_upload = mysqli_query($conn, $select_query);

    return $results_upload;
}

function getSettingsUser($username, $conn) {

$query_settings = "SELECT * FROM user_defaults WHERE user_username='$username'";
$row = mysqli_fetch_row(mysqli_query($conn, $query_settings));

return $row;
}


function getFileDataFromUser ($id, $conn) {
    if(isset($id)) {
        $id_filtered = mysqli_real_escape_string($conn, $id);
        $get_file_contents = "SELECT * FROM `files` WHERE unique_id='$id_filtered'";
        $result = mysqli_query($conn, $get_file_contents);
        
        return $result;
    }
}

