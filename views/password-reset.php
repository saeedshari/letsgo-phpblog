<?php
require_once('../inc/navbar.php');
?>

<div class="container px-4 mt-5">
    <?php
        if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo $_SESSION['error'];?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        <?php
            unset($_SESSION['error']);

        }elseif(isset($_SESSION['successful']) && !empty($_SESSION['successful'])){
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><a href="<?php echo $_SESSION['successful'];?>">لینک تغییر رمز</a></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        <?php
            unset($_SESSION['successful']);
        }
        ?>
    <div class="row">
        <div class="card shadow rounded-3">
            <div class="card-body">
                <div class="card-title">
                    <h3>ایمیل بازیابی رمز عبور</h3>
                </div>
                <div class="row gx-5 align-items-center">
                <div class="col-md">
                <form action="../control/password-reset.php" method="post">
                    <div class="form-floating mb-3">
                        <input name="email" type="text" class="form-control" id="floatingInput" placeholder="آدرس ایمیل">
                        <label class="custom-label" for="floatingInput">آدرس ایمیل</label>
                    </div>

                    <div class="d-grid my-4">
                    <input class="btn btn-custom" type="submit" name="submit" value="ارسال">
                    </div>
                </form>
                </div> <!-- col-md -->

                <div class="col-md d-none d-md-block">
                <img src="./images/forget-password.svg" class="img-fluid" alt="...">
                </div> <!-- col-md -->

                </div> <!-- row -->
            </div> <!-- card-body -->
        </div> <!-- card -->
</div> <!-- row -->
</div> <!-- container -->

<?php
    require_once ('../inc/script.php');
?>
