<?php
session_start();
session_destroy();
$successMsg = "Succesfully logged out";
header("Location: ../login.php?success=$successMsg");
exit;