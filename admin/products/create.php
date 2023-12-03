<?php
require __DIR__.'/../template/header.php';

$errors = [];

function canUpload($file){

    $allowed = [
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif'
    ];
    $maxSize = 10 *1024 * 1024;

    if($maxSize< $file['size']){
        array_push($errors, "The image size is not allowed, 10 MG is allowed at maximum.");
    }
    if(!in_array($file['type'], $allowed)){
        array_push($errors, "Image type is not allowed, only png, jpg and gif are allowed.");
    }
    return true;
}


$name = $description = $price = $image = $amount = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
    $price = mysqli_real_escape_string($mysqli, $_POST['price']);
    $amount = mysqli_real_escape_string($mysqli, $_POST['amount']);
    $image = $_FILES['image'];
    if(empty($name)) array_push($errors, "Name is required");
    if(empty($description)) array_push($errors, "Description is required");
    if(empty($price)) array_push($errors, "price is required");
    if(empty($image)) array_push($errors, "Image is required");

    if(empty($errors)){
        $canUpload = canUpload($image);

        if ($canUpload){
            $uploadDir = 'uploads';
            if (!is_dir($uploadDir)){
                umask(0);
                mkdir($uploadDir, 0775);
            }
            $fileName = time().$image['name'];
            if(file_exists($fileName)){
                array_push($errors, "File already exists");
            }else{
                move_uploaded_file($image['tmp_name'], $uploadDir.'/'.$fileName);
            }
            $mysqli->query("insert into products (name, description, price, image)".
                "values('$name', '$description', '$price', '$fileName')");
            echo "<script>location.href='index.php'</script>";
        }

    }


}

?>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="" method="post" enctype="multipart/form-data">
                <?php include __DIR__.'/../../template/error.php' ?>
                <div class="form-group">
                    <label for="name">Product name</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description">
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" name="price">
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" class="form-control">
                </div>
                <div>
                    <button class="btn btn-outline-success">Creat</button>
                </div>
            </form>
        </div>
    </div>

</div>


<?php require __DIR__.'/../template/footer.php' ?>
