<?php
require __DIR__.'/../template/header.php';
$userId = $_SESSION['user_id'];
$userCourses = $mysqli->query("select * from courses c ".
    "right join payments p on c.id = p.course_id where p.user_id = '$userId'")->fetch_all(MYSQLI_ASSOC);



?>

<div class="row mt-5">
    <?php foreach ($userCourses as $userCourse): ?>
    <div class="col-4">

        <div class="card">
            <div class="card-image-custom" style="background-image: url(<?php echo $config['admin_url'].'courses/uploads/'.$userCourse['image'] ?>)">

            </div>
            <div class="card-body">

                <p><?php echo $userCourse['description'] ?></p>
                <a href="course.php?id=<?php echo $userCourse['id'] ?>" class="btn btn-primary">Open</a>
            </div>
        </div>

    </div>
    <?php endforeach; ?>
</div>










<?php require __DIR__.'/../template/footer.php' ?>
