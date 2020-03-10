<?php 
require "./config/config.php";
require "./headers/header.php"; 
?>
<div class="login-bg">
    <div class="form-center register">
    <h2 class='left-login'>Create User</h2>
    <br>
    
        <form class="ui form" action="form_handlers/register_user.php" method="post">
        <div class="field">
            <label>First Name</label>
            <input type="text" name="f_name" placeholder="Enter your first name" required>
        </div>
        <div class="field">
            <label>Last Name</label>
            <input type="text" name="l_name" placeholder="Enter your last name" required>
        </div>
        <div class="field">
            <label>Password</label>
            <input type="password" name="reg_pw" placeholder="Choose a strong & unique password" required>
        </div>
        <div class="field">
            <label>Retype Password</label>
            <input type="password" name="reg_pw2" placeholder="Type your password again" required>
        </div>
        <div class="field">
            <label>Username</label>
            <input type="text" name="reg_username" placeholder="Choose a username to log-in with" required>
        </div>
        <p class='error-msg' style='color:red'><?php if(isset($_GET['error'])){
                    echo($_GET['error']);
        }?></p>
        <button class="ui button" type="submit">Create User</button>
        <div class="field">
            <div class="ui">
            <a href="login.php" class='switch-link'>Already have an account?</a>
            </div>
        </div>
        <input type="hidden" name="redirect" value='<?php if(isset($_GET['rp'])) {    
                echo($_GET['rp']) ;}?>'>
        </form>
    </div>
</div>
</body>
</html>