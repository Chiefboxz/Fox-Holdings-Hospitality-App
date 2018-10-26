<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/lecafe/core/init.php';
if(!is_logged_in()){
        login_error_redirect();
    }
include 'includes/head.php';

$hashed = $user_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['id'];
$errors = array();
?>
<style>
    body{
        background-image: url("/lecafe/images/headerlogo/background.png");
        background-size: 100vw 100vh;
        background-attachment: fixed;
    }
</style>

<div id="login-form">
    <div>
    <?php
        if($_POST){
            //form validation
            if(empty($_POST['old_password']) || empty($_POST['password'])){
                $errors[] = 'You must provided a password.';
            }
            //password more than 6 char
            if(strlen($password) < 6){
                $errors[] = 'Password must be at least 6 characters.';
            }
            
            //if new password matches confirm
            if($password != $confirm){
                $errors[] = 'Password does not match.';
            }
            
            if(!password_verify($old_password, $hashed)){
                $errors[] = 'Your old password is incorrect';
            }
            
            //check for errors
            if(!empty($errors)){
                echo display_errors($errors); 
            }else{
                //change password
                $db->query("UPDATE user SET password = '$new_hashed' WHERE id = '$user_id'");
                $_SESSION['success_flash'] = 'Your password has been changed!';
                header('Location: /lecafe/index.php');
            }
        }
        ?>
    </div>
    <h2 class="text-center">Change password</h2><hr>
    <form action="change_password.php" method="post">
        <div class="form-group">
            <label for="old_password">Old Password:</label>
            <input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>" >
        </div>
        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>" >
        </div>
        <div class="form-group">
            <label for="confirm">Confirm new password:</label>
            <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>" >
        </div>
        <div class="form-group">
            <a href="/lecafe/admin/index.php" class="btn btn-default">Cancel</a>
            <input type="submit" value="Change password" class="btn btn-primary">
        </div>
    </form>
</div>

<?php 
include 'includes/footer.php';
?>