<?php 
require "./config/config.php";
require "./config/authentication.php";
require "./headers/header.php"; 

// check login before continuing
checkUser("index.php" ,"Must be logged in to view this content.", $conn);

//use any authenticated functions after this line
$results_files = getFilesFromUser($_SESSION['username'],$conn); 
$results_uploads = getUploadsFromUser($_SESSION['username'],$conn); //function that runs a call to files for all files relating t this perticualr user
$num_rows = mysqli_num_rows($results_files);

$settings = getSettingsUser($_SESSION['username'], $conn);


?>
<div class="bg-light">

        

    <div class="files">
        <h2 class='recent-files'>Your Cloud Storage</h2>
        <h4 style='margin:0px 0px 10px 0px;color:#333333;'>You have currently used <?php echo($settings[2]); ?> of storage space. You have <?php echo($settings[4]);?>GB of Max Storage.</h4>

        <button id='upload-file-btn' class="ui primary button">Upload</button>
        <?php if(isset($_GET['smsg'])) {?>
        <div class="ui success message">
            <div class="header">Upload Completed!</div>
            <p><?php echo($_GET['smsg']);?></p>
        </div>
        <?php }?>

        <?php if(isset($_GET['emsg'])) {?>
        <div class="ui warning message">
            <div class="header">Something Went Wrong!</div>
            <p><?php echo($_GET['emsg']);?>
        </div>
        <?php }?>
        <div class="ui cards" style='margin-top: 16px;'><?php 
            while ($row = mysqli_fetch_row($results_uploads)) {?>
                <div class="card upload-card" >
                    <div class="content">
                        <a href='file.php?fid=<?php echo($row[0]); ?>' class="header left header-txt"><?php echo($row[7]);?></a>
                        <div class="meta left">Uploaded: <?php echo($row[3]); ?></div>
                        <p class='meta left'>Type: <?php echo($row[6]); ?> (<?php echo($row[8]) ?>)</p>
                        <a class="meta left" style='color:#2185D0;cursor:pointer;' download href='./<?php echo($row[4]); ?>'>Download</a>
                    </div>
                </div> 
            <?php } ?>
        </div>
        
    <div id="uploadModal" class='modal_upload'>
    <div class="modal-content-upload">
    
        <form action="./form_handlers/upload_file.php" method="post" enctype="multipart/form-data">
            <h2 class='header-upload-modal'>Upload a File</h2>
            <input type="hidden" name="author_username" value='<?php echo($_SESSION['username']);?>'>
            <p class='upload-p'>Choose a file to upload and store on the cloud.</p>
            <label for="upload_input"  class='ui primary button'>
                <span class="glyphicon glyphicon-folder-open" aria-hidden="true">Choose</span>
                <input type="file" id="upload_input" name="file"  style="display:none" required>
            </label>
            <label for="close"  class='ui button secondary' id='close_trigger'>
                <span>Cancel</span>
            </label>
            <br>
            <button class='button positive ui' id='submit-btn' onclick="state=true;" type="submit" name='submit'>Upload</button>
        </form>
        <button style='display:none;' id='close'></button>
    </div>
</div>


<script src="./design/upload_modal.js"></script>
<script src="./js/cancelhttp.js"></script>
</body>
</html>