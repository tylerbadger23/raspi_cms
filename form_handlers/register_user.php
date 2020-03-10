<?php
require "../config/config.php";
//make sure data is passed into fields correctly and securely
//data to filter: email, password,password2,   create username from email

$f_name = strtolower(mysqli_real_escape_string($conn, $_POST['f_name']));
$l_name = strtolower(mysqli_real_escape_string($conn, $_POST['l_name']));
$password = mysqli_real_escape_string($conn, $_POST['reg_pw']);
$password2 = mysqli_real_escape_string($conn, $_POST['reg_pw2']);
$username = mysqli_real_escape_string($conn, $_POST['reg_username']);

//PASSWORD CHECKS
if($password !== $password2) {
    $errorMsg = "Passwords do not match. Please make sure they are identical";
    header("Location: ../register.php?error=$errorMsg");
    exit;
} else if (strlen($password) < 4 || strlen($password2) < 4){
    $errorMsg = "Password is too short. Must be longer than 4 characters.";
    header("Location: ../register.php?error=$errorMsg");
    exit;
}


if (strlen($username) < 4 || strlen($username) > 16) {
    $errorMsg = "Your username must be between 4 and 16 characters";
    header("Location: ../register.php?error=$errorMsg");
    exit;
}
// check username availability


$hashed_password = md5($password);
//filter data BEFORE PUBLISHING
$username_check_query = "SELECT id FROM users WHERE username='$username'";
$username_query_results = mysqli_query($conn, $username_check_query);

if(mysqli_num_rows($username_query_results) > 0) {
    $errorMsg = "username is  already in use. Please choose another one or login";
    header("Location: ../register.php?error=$errorMsg");
    exit;
} else {

    $query = "INSERT INTO `users` (`id`, `email`, `password`,`username`,`f_name`,`l_name`) VALUES (NULL, '0', '$hashed_password','$username','$f_name','$l_name')";
    if(mysqli_query($conn, $query)){
        $uid_query = "SELECT id FROM `users` WHERE username='$username'";
        $result = mysqli_query($conn, $uid_query);
        $uid_row = mysqli_fetch_row($result);
      
        $uid = $uid_row[0];

        $user_prefs_query = "INSERT INTO `user_defaults` (`user_id`, `user_username`,`user_storage_used`, `max_allowed_storage`, `theme_preferences`, `bytes_user_used`) VALUES ('$uid', '$username', '0', '50','1', '10')";
        if(mysqli_query($conn, $user_prefs_query)) {
            $successMsg = "Successfully Created New Account";
            $_SESSION['username'] = $username;
            $_SESSION['uid'] = $uid;
            header("Location: ../index.php?s=$successMsg");
            exit;
        } else {
            $successMsg = "HOLLY ERROR!!!!";
            header("Location: ../index.php?s=$successMsg");
            exit;
        }
    }

}

