<?php
require __DIR__.'/../template/header.php';
$users = $mysqli->query('select * from users order by id')->fetch_all(MYSQLI_ASSOC);


$userId = '';
$errors = [];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $userId = mysqli_real_escape_string($mysqli, $_POST['id']);
    if(empty($userId)) array_push($errors, "Chose a user to delete");

    if(empty($errors)){
        $mysqli->query("delete from users where id ='$userId'");
        echo "<script>location.href='index.php'</script>";
    }
}
?>



    <div class="row">
        <div class="col-8">
            <?php include __DIR__.'/../../template/error.php' ?>
            <table class="table">
                <?php if(isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION['success']) ?>
                <?php } ?>
                <thead class="table-header">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($users as $user){ ?>
                <tr>
                    <td><?php echo $user['id'] ?></td>
                    <td><?php echo $user['name'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['role'] ?></td>
                    <td>
                        <a href="<?php echo $config['admin_url'] ?>users/edit.php?id=<?php echo $user['id'] ?>" class="btn btn-outline-warning">Edit</a>
                        <form action="" method="post" style="display: inline" onsubmit="return confirm('Are you sure?')">
                            <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
                            <button class="btn btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>
    </div>


<?php require __DIR__.'/../template/footer.php' ?>
