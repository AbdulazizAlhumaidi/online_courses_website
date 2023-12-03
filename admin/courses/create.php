<?php
require __DIR__.'/../template/header.php';

function validation($file){

    $allowed = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif'
    ];
    $maxSize = 10 * 1024 * 1024 ;

    if($maxSize< $file['size']){
        return 'File size is not allowed, only 10MG is allowed';
    }
    if(!in_array($file['type'],$allowed)){
        return 'File type is not allowed, only jpg and png are allowed';
    }
    return true;
}
$errors = [];

$name = $description = $image = $price = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
    $price = mysqli_real_escape_string($mysqli, $_POST['price']);

    $image = $_FILES['image'];
    $is_validated = validation($_FILES['image']);

    if(empty($name)) array_push($errors, "Name is required");
    if(empty($description)) array_push($errors, "description is required");
    if(empty($image)) array_push($errors, "image is required");
    if(empty($price)) array_push($errors, "price is required");

    if(!count($errors)){
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
            if($is_validated === true){
                $uploadDir = 'uploads';
                if(!is_dir($uploadDir)){
                    umask(0);
                    mkdir($uploadDir, 0775);
                }
                $fileName = time().$_FILES['image']['name'];

                if(file_exists($_FILES['image']['name'])){
                    array_push($errors, 'File already exists');
                }else{
                    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.'/'.$fileName);
                    $mysqli->query("insert into courses (name, description, image, price)".
                        "values('$name', '$description','$fileName', '$price')");
                    $_SESSION['success'] = "Data inserted successfully";
                    echo "<script>location.href='index.php'</script>";
                }

            }else{
                array_push($errors, $is_validated);
            }

        }else{
            array_push($errors, 'File is required');
        }
    }




}





?>






<div class="row justify-content-center">
    <div class="col-6">
        <?php include __DIR__.'/../../template/error.php'?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Course name</label>
                <input type="text" class="form-control" name="name" placeholder="Course name">
            </div>
            <div class="form-group">
                <label for="description">Course description</label>
                <input type="text" class="form-control" name="description" placeholder="Course description">
            </div>
            <div class="form-group">
                <label for="price">Course price</label>
                <input type="text" class="form-control" name="price">
            </div>
            <div class="form-group">
                <label for="name">Course image</label>
                <input type="file" class="form-control" name="image">
            </div>

            <div>
                <button class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>

</div>




<?php
$errors = [];
require __DIR__.'/../../template/footer.php'?>
