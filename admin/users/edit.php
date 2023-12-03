<?php

require __DIR__.'/../template/header.php';

if (!isset($_GET['id']) || !$_GET['id']){
    die('Missing ID parameter');
}

$user_id = $_GET['id'];
$user = $mysqli->query("select * from users where id ='$user_id' limit 1")->fetch_assoc();


$name = $user['name'];
$email = $user['email'];
$role = $user['role'];


$nameError = $emailError = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

$name = $_POST['name'];
$email = $_POST['email'];
$role = $_POST['role'];

if(empty($name)) $nameError = "Name is required";
if(empty($email)) $emailError = "Email is required";

if(!$nameError && !$emailError){
    $mysqli->query("update users set name='$name', email ='$email', role='$role' where id='$user_id'");
    $_SESSION['success'] = "Data updated successfully";
    echo "<script>location.href='index.php'</script>";

}


}

?>


<div class="container">
    <form action="" method="post">
        <div class="mb-4">
            <label for="name">User name</label>
            <input type="text" class="form-control" name="name" placeholder="User name" value="<?php echo $name ?>">
            <span class="text-danger"><?php echo $nameError ?></span>
        </div>
        <div class="mb-4">
            <label for="email"></label>
            <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $email ?>">
            <span class="text-danger"><?php echo $emailError ?></span>
        </div>
        <div class="mb-4">
            <select name="role" id="" class="form-control">

                <option <?php if($role == 'user'){ echo 'selected';}?>
                    value="user">User</option>
                <option <?php if($role == 'admin'){echo 'selected';} ?>
                    value="admin">Admin</option>
            </select>
        </div>
        <div>
            <button class="btn btn-outline-primary">Save</button>
        </div>
    </form>
</div>



<?php require __DIR__.'/../template/footer.php' ?>
