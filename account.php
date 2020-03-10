<?php 
require "./config/config.php";
require "./config/authentication.php";
require "./headers/header.php"; 

// check login before continuing
checkUser("index.php" ,"Must be logged in to view this content.",$conn );

$settings = getSettingsUser($_SESSION['username'], $conn);


?>

<h3>You have currently used <?php echo($settings[2]); ?> of storage space. You have <?php echo($settings[4]);?>GB of Max Storage.</h3>

</body>
</html>