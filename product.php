<?php
require 'template/header.php';
$products = $mysqli->query("select * from products")->fetch_all(MYSQLI_ASSOC);
?>
<div class="row">
    <?php foreach($products as $product): ?>
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                <?php echo $product['name'] ?>
            </div>
            <div class="card-body">
                <div class="card-image-custom" style="background-image:
                    url(<?php echo $config['admin_url'].'products/uploads/'.$product['image'] ?>)"></div>
                <p><?php echo $product['price'] ?> SAR</p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php require 'template/footer.php'?>