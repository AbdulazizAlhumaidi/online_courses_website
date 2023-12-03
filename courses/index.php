<?php

require __DIR__.'/../template/header.php';
require __DIR__.'/../config/database.php';

$courses = $mysqli->query('select * from courses')->fetch_all(MYSQLI_ASSOC);
$userId = '';
if (isset($_SESSION['user_id'])){
    $userId = $_SESSION['user_id'];
}

$payments = $mysqli->query("select course_id from users u
    right join payments p on u.id = p.user_id where id ='$userId'");

$counter = $payments->num_rows;

$isBought = $payments->fetch_all(MYSQLI_ASSOC);
?>
    <div class="container-fluid bg-secondary">
        <div class="row bg-light">
            <?php foreach($courses as $course): ?>
                <div class="col-4 mt-3">

                    <div class="card bg-light">
                        <div class="card-header">
                            <?php echo $course['name'] ?>
                        </div>
                        <div class="card-body">
                            <a href="course.php?id=<?php echo $course['id'] ?>">
                                <div class="card-image-custom"
                                     style="background-image:
                                         url(<?php echo $config['admin_url'].'courses/uploads/'. $course['image'] ?>)">
                                </div>
                            </a>
                            <p><?php echo $course['description'] ?></p>

                            <?php for($i=0; $i<$counter; $i++){
                                if($course['id'] == $isBought[$i]['course_id']){
                                    $subscribed = true;
                                    break;
                                }else{
                                    $subscribed = false;
                                }
                            }
                            if(isset($subscribed) && $subscribed == true){
                                ?>
                                <a href="course.php?id=<?php echo $course['id'] ?>" class="btn btn-outline-primary mt-1">Open</a>
                            <?php }else{
                                    if($course['status'] == 'open'){ ?>
                                <p class="text-secondary">Price <?php echo $course['price'] ?></p>
                                <a href="course.php?id=<?php echo $course['id'] ?>" class="btn btn-outline-primary mt-1">Buy</a>
                            <?php }else{ ?>
                                        <div class="text-danger mt-1">Closed</div>
                                <?php }} ?>
                         </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php require __DIR__.'/../template/footer.php' ?>