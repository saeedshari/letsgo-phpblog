<!DOCTYPE html>
<!-- Created by saeed shari -->
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Framework -->
    <link rel="stylesheet" type='text/css' href="../views/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" type='text/css' href="../views/css/style.css">
    <title>Responsive PHP Blog | Saeed Shari</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../views/images/blog.png" width="30" height="30" class="d-inline-block align-text-top">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php
                        session_start();
                        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                            if(isset($_SESSION['nickname']) && !empty($_SESSION['nickname'])){
                                echo $_SESSION['nickname'];
                            }
                        }else{
                            echo "Hello Guest";
                        }
                        ?>
                </a>
                <?php
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                    ?>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    switch($_SESSION['privil']){
                        case ($_SESSION['privil'] === 0):
                            ?>
                    <li><a class="dropdown-item" href="">پست جدید</a></li>
                    <?php
                            break;
                            case ($_SESSION['privil'] === 1):
                            ?>
                    <li><a class="dropdown-item" href="../views/create.php">پست جدید</a></li>
                    <li><a class="dropdown-item" href="../control/index.php">لیست پست ها</a></li>
                    <?php
                            break;
                    }
                    ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="../views/change-email.php" class="dropdown-item">
                        تغییر ایمیل
                    </a></li>
                    <li><a href="../views/change-password.php" class="dropdown-item">
                        تغییر رمز عبور
                    </a></li>
                    <li><a href="../views/nickname.php" class="dropdown-item">
                        اسم مستعار
                    </a></li>
                <?php
            }
            ?>
                    </ul>
                </li>
            </ul>
            <?php
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                ?>
                <a href="../views/logout.php" class="btn btn-secondary me-2" type="button">خروج</a>
                <?php
            }else{
                ?>
                <a href="../views/register.php" class="btn btn-success me-2" type="button">ثبت نام</a>
                <a href="../views/login.php" class="btn btn-outline-secondary me-2" type="button">ورود</a>
            <?php
                }
            ?>
            </div>
        </div>
    </nav>

<?php
require_once ('script.php');
?>