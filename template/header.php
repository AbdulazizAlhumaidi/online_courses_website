<?php
session_start();
require __DIR__.'/../config/app.php';
require __DIR__.'/../config/database.php';

?>

<!DOCTYPE html>
<html lang="<?php echo $config['lang'] ?>" dir="<?php echo $config['dir'] ?>">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo $config['app_url'] ?>/template/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">

    <title><?php echo $config['app_name'] ?></title>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-dark navbar-dark text-light">
    <div class="container">
        <a href="" class="navbar-brand"></a>

        <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainmenu"><span class="navbar-toggler-icon"></span></button>

        <div class="collapse navbar-collapse" id="mainmenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="<?php echo $config['app_url'] ?>index.php" class="nav-link">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $config['app_url'] ?>courses/index.php" class="nav-link">الدورات</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $config['app_url'] ?>product.php" class="nav-link">المنتجات</a>
                </li>
                <?php if(!isset($_SESSION['logged_in'])){ ?>
                <li class="nav-item">
                    <a href="<?php echo $config['app_url'] ?>login.php" class="nav-link">تسجيل الدخول</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $config['app_url'] ?>register.php" class="nav-link">التسجيل</a>
                </li>
                <?php }else{ ?>
                        <li class="nav-item">
                            <a href="<?php echo $config['app_url'] ?>courses/my-courses.php" class="nav-link">دوراتي</a>
                        </li>
                <li class="nav-item">
                    <a href="<?php echo $config['app_url'] ?>logout.php" class="nav-link">تسجيل الخروج</a>
                </li>

                <?php } ?>
                <li class="nav-item">
                    <a href="<?php echo $config['app_url'] ?>contact.php" class="nav-link">تواصل معنا</a>
                </li>
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                <li class="nav-item">
                    <a href="<?php echo $config['admin_url'] ?>" class="nav-link">لوحة التحكم</a>
                </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>



<div class="container bg-light">

