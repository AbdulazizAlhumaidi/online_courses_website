<?php
require 'template/header.php';
require 'config/database.php';

$email = $password = '';
$emailError = $passwordError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email)){
        $emailError = "Email is required";
    }
    if(empty($password)){
        $passwordError = "Password is required";
    }

    if(!$emailError && !$passwordError){

        $userExists = $mysqli->query("select * from users where email = '$email'");

        if(!$userExists->num_rows){
            $emailError = "Your email does not exist";
        }else{
            $foundUser = $userExists->fetch_assoc();
            if(password_verify($password ,$foundUser['password'])){
                header('location: index.php');
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $foundUser['id'];
                $_SESSION['user_role'] = $foundUser['role'];
            }else{
                $passwordError = 'Incorrect password';
            }
        }

    }




}


?>


<form action="" class="form-group" method="post">
    <?php if(isset($_SESSION['sign_in'])){ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php
            echo $_SESSION['sign_in'];
            unset($_SESSION['sign_in']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
    <?php if(isset($_SESSION['error_message'])){ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php
            echo $_SESSION['error_message'];
            unset($_SESSION['error_message']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <div class="mb-3">
        <label for="">البريد الالكتروني</label>
        <input type="email" name="email" class="form-control" value="<?php echo $email ?>" placeholder="البريد الالكتروني">
        <span class="text-danger"><?php if(isset($emailError)){echo $emailError;} ?></span>
    </div>
    <div class="mb-3">
        <label for="">كلمة المرور</label>
        <input type="password" name="password" class="form-control" placeholder="كلمة المرور">
        <span class="text-danger"><?php if(isset($passwordError)){echo $passwordError;} ?></span>
    </div>
    <button class="btn btn-success">دخول</button>
</form>




<?php require 'template/footer.php'?>
