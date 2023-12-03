<?php


if (count($errors)) : ?>

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php foreach ($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>


<?php endif;

