<?php
require __DIR__.'/../template/header.php';

$errors = [];

if(!isset($_GET['id'])){
    die("Missing ID parameter");
}
$course_id = $_GET['id'];

$course = $mysqli->query("select * from courses where id='$course_id'")->fetch_assoc();

$name = $description = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);

    $allowed = [
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif'
    ];
    $maxSize = 10 * 1024 * 1024;
    $image = $_FILES['image'];

    if(empty($name)) array_push($errors, "Name is required");
    if(empty($description)) array_push($errors, "Description is required");
    if(empty($_FILES['image']['name'])) array_push($errors, "Image is required");

    if(!in_array($image['type'], $allowed)){
        array_push($errors, 'Image type is not allowed');
    }

    if($maxSize < $image['size']){
        array_push($errors, 'Image size is not allowed');
    }
    if(!$errors){
        $image_name = time().$image['name'];
        $uploadDir = 'uploads';
        if(!is_dir($uploadDir)){
            umask(0);
            mkdir($uploadDir, 0775);
        }
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.'/'.$image_name);

        $mysqli->query("update courses set name='$name', description = '$description', image= '$image_name'".
            " where id ='$course_id'");
        echo "<script>location.href='index.php'</script>";
    }



}

?>
<div class="row justify-content-center">
    <div class="col-6 ">
        <?php include __DIR__.'/../../template/error.php'?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Course name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $course['name'] ?>">
            </div>
            <div class="form-group">
                <label for="description">Course description</label>
                <input type="text" name="description" class="form-control" value="<?php echo $course['description'] ?>">
            </div>
            <div class="form-group">
                <label for="image">Course name</label>
                <input type="file" name="image" class="form-control" value="<?php echo $course['image'] ?>" >
            </div>
            <div>
                <button class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>



<?php require __DIR__.'/../template/footer.php' ?>
