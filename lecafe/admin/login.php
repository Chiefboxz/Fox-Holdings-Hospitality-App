<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/lecafe/core/init.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$hashed = password_hash($password, PASSWORD_DEFAULT);
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
            if(empty($_POST['email']) || empty($_POST['password'])){
                $errors[] = 'You must provide email and password.';
            }
            //valid email
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $errors[] = 'You must enter a valid email';
            }
            //password more than 6 char
            if(strlen($password) < 6){
                $errors[] = 'Password must be at least 6 characters.';
            }
            
            // check if email exists in database
            $query = $db->query("SELECT * FROM user WHERE email = '$email'");
            $user = mysqli_fetch_assoc($query);
            $userCount = mysqli_num_rows($query);
            if($userCount < 1){
                $errors[] = 'That email doesnt exist';
            }
            
            if(!password_verify($password, $user['password'])){
                $errors[] = 'The password is incorrect, try again';
            }
            
            //check for errors
            if(!empty($errors)){
                echo display_errors($errors); 
            }else{
                $user_id = $user['id'];
                login($user_id);
            }
        }
        ?>
    </div>
    <h2 class="text-center">Login</h2><hr>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>" >
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>" >
        </div>
        <div class="form-group">
            <input type="submit" value="Login" class="btn btn-primary">
            
        </div>
    </form>
</div>

<?php 
include 'includes/footer.php';
?>