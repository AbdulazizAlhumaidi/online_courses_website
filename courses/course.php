<?php
require __DIR__.'/../template/header.php';

if(!isset($_GET['id'])){
    echo "<script>location.href='index.php'</script>";
}

$courseId = $_GET['id'];
$userId = '';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
    $userId = $_SESSION['user_id'];
}

$course = $mysqli->query("select * from courses where id ='$courseId'")->fetch_assoc();

$isBought = $mysqli->query("select * from courses c
    left join payments p
    on c.id = p.course_id
    where c.id = '$courseId' and p.user_id = '$userId'")->fetch_assoc();


if(!isset($_SESSION['logged_in'])){
    echo "<script>location.href='/my-website/login.php'</script>";
    $_SESSION['sign_in'] = "Please sign in to to buy this course";
}

if(!$isBought){
    $id = '';
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!isset($_SESSION['logged_in'])){
            echo "<script>location.href='login.php'</script>";
        }
        $id = mysqli_real_escape_string($mysqli, $_POST['id']);
        echo $id;
        if(empty($id)) array_push($errors, "Chose a course");

        if(empty($errors)){
            $userId = $_SESSION['user_id'];
            $mysqli->query("insert into payments (user_id, course_id) values('$userId', '$courseId')");
            $_SESSION['success'] = "You successfully bought this course";
            header("location:course.php?id=".$id);
            die();
        }
    }
?>

    <div class="row mt-5">
        <?php include __DIR__.'/../template/error.php' ?>

        <?php if(isset($_SESSION['success'])) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']) ?>
        <?php } ?>
        <div class="col-4">
            <div class="sidebar">
                <div class="card">
                    <div class="">
                        <img src="<?php echo $config['app_url'].'admin/courses/uploads/'. $course['image'] ?>" alt="">
                    </div>
                    <div class="card-body">
                        <?php echo $course['price'] ?>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $courseId ?>">
                            <?php if($course['status'] == 'open'){ ?>
                              <button class="btn btn-outline-primary">Buy</button>
                            <?php }else{?>
                            <div class="text-danger">Closed</div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}else{
?>
    <div class="row mt-5">
        <?php if(isset($_SESSION['success'])) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']) ?>
        <?php } ?>
        <div class="col-4">
            <div class="sidebar">
                <div class="card">
                    <div class="">
                        <img src="<?php echo $config['app_url'].'admin/courses/uploads/'. $course['image'] ?>" alt="">
                    </div>
                    <div class="card-body">
                        <?php echo $course['price'] ?>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $courseId ?>">
                                <button class="btn btn-outline-primary">Open</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}
require __DIR__.'/../template/footer.php';


?>
