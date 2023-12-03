<?php
require __DIR__.'/../template/header.php';
$productId = '';
$errors = [];
if(!isset($_GET['id'])){
    die("ID parameter is missing");
}else{
    $productId = $_GET['id'];
}
$product = $mysqli->query("select * from products where id = '$productId'")->fetch_assoc();

$name = $description = $price = $image = $amount = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
    $price = mysqli_real_escape_string($mysqli, $_POST['price']);
    $amount = mysqli_real_escape_string($mysqli, $_POST['amount']);

//     if(isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0){
//         $image = mysqli_real_escape_string($mysqli, $_FILES['image']['name']);
//     }else{
//         $image = $product['image'];
//     }
//     echo $image;



    $allowed = [
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif'
    ];
    $maxSize = 10 * 1024 * 1024;
    $image = $_FILES['image'];

    if(empty($name)) array_push($errors, "Name is required");
    if(empty($description)) array_push($errors, "Description is required");
    if(empty($price)) array_push($errors, "Price is required");
    if(empty($amount)) array_push($errors, "Amount is required");
    if(empty($image)) array_push($errors, "Image is required");

    if($_FILES['image']){

//         if(!in_array($image['type'], $allowed)){
//            array_push($errors, 'Image type is not allowed');
//     }
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

        $mysqli->query("update products set name='$name', description = '$description', image= '$image_name', amount = '$amount' where id ='$productId'");
         echo "<script>location.href='index.php'</script>";
    }
    echo $amount;


}

?>

<div class="row">
    <div class="col-2">
        <div class="card-image-custom" style="background-image:
            url(<?php echo $config['admin_url'].'products/uploads/'. $product['image'] ?>)"></div>
    </div>
    <div class="col-6">
        <form action="" method="post" enctype="multipart/form-data">
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div><?php echo $_SESSION['success'] ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php include __DIR__.'/../../template/error.php' ?>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?php echo $product['name'] ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" value="<?php echo $product['description'] ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input id="price" type="text" name="price" value="<?php echo $product['price'] ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" value="<?php echo $product['image'] ?>" >
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" value="<?php echo $product['amount'] ?>" class="form-control">
            </div>
            <div>
                <button class="btn btn-warning">Edit</button>
            </div>
        </form>
    </div>
</div>




<?php require __DIR__.'/../template/footer.php'; ?>
