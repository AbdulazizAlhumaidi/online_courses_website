<?php
require __DIR__.'/../template/header.php';

$products = $mysqli->query("select * from products")->fetch_all(MYSQLI_ASSOC);

$productId = '';
$errors = [];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $productId = mysqli_real_escape_string($mysqli, $_POST['id']);
    if(empty($productId)) array_push($errors, 'You have to chose an item to delete');
    if(empty($errors)){
        $mysqli->query("delete from products where id ='$productId'");
    }
    if ($_POST['id']){
        unlink($_SERVER['DOCUMENT_ROOT'] . '/my-website/admin/products/uploads/'.$_POST['image']);
    }

    echo "<script>location.href='index.php'</script>";
}


?>
<div class="container-fluid">



    <?php include __DIR__.'/../../template/error.php' ?>
    <a href="create.php" class="btn btn-success">Creat</a>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Amount</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['id'] ?></td>
                <td><?php echo $product['name'] ?></td>
                <td><?php echo $product['description'] ?></td>
                <td><?php echo $product['price'] ?></td>
                <td>
                    <img src="<?php echo $config['admin_url'].'products/uploads/'. $product['image'] ?>" alt="">

                </td>
                <td><?php echo $product['amount'] ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $product['id'] ?>" class="btn btn-outline-warning">Edit</a>
                    <form action="" method="post" style="display: inline" onsubmit="return confirm('Are you sure?')">
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                        <input type="hidden" name="image" value="<?php echo $product['image'] ?>">
                        <button  class="btn  btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>




<?php require __DIR__.'/../template/footer.php'; ?>
