<?php 
require "./config/config.php";// must be on top
require "./config/authentication.php";
require "./headers/header.php"; 

// check login before continuing
checkUser("index.php" ,"Must be logged in to view this content", $conn);

?>

<div class="imgElement">
    <img src="..." class="img-fluid" ">
</div>
<script src="https://vjs.zencdn.net/7.6.6/video.js"></script>


</body>
</html>