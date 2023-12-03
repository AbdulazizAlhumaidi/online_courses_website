<?php
require 'template/header.php';
require 'config/database.php';

$nameError = $emailError = $passwordError = $passwordConfirmationError = '';
$name = $email = $password = $role = '';
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if(empty($name)){
        $nameError = 'Name is required';
    }
    if(empty($email)){
        $emailError = 'Email is required';
    }
    if(empty($password)){
        $passwordError = 'Password is required';
    }
    if($_POST['password'] != $_POST['password_confirmation']){
        $passwordConfirmationError = "Passwords don't match";
    }
    if(!$nameError && !$emailError && !$passwordError && !$passwordConfirmationError){
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
        $mysqli->query("insert into users (name, email, password, role)".
        "values ('$name','$email', '$passwordHashed', '$role')");
        echo "<script>location.href='index.php'</script>";
    }
}
?>
<form action="" class="form-group" method="post">
    <div class="mb-3">
        <label for="">اسم المستخدم</label>
        <input type="text" name="name" class="form-control" placeholder="اسم المستخدم">
        <span class="text-danger"><?php if(isset($nameError)){echo $nameError;} ?></span>
    </div>
    <div class="mb-3">
        <label for="">البريد الالكتروني</label>
        <input type="email" name="email" class="form-control" placeholder="البريد الالكتروني">
        <span class="text-danger"><?php if(isset($emailError)){echo $emailError;} ?></span>
    </div>
    <div class="mb-3">
        <label for="">كلمة المرور</label>
        <input type="password" name="password" class="form-control" placeholder="كلمة المرور">
        <span class="text-danger"><?php if(isset($passwordError)){echo $passwordError;} ?></span>
    </div>
    <div class="mb-3">
        <label for="">تأكيد كلمة المرور</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="تأكيد كلمة المرور">
        <span class="text-danger"><?php if(isset($passwordConfirmationError)){ echo $passwordConfirmationError;} ?></span>
    </div>
    <div class="mb-3">
        <label for="role"></label>
        <select name="role" class="form-select" id="">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <button class="btn btn-success">تسجيل</button>
</form>

<?php require 'template/footer.php'?>
