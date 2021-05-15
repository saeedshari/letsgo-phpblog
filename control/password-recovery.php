<?php
require_once('../inc/connection.php');

if (isset($_GET['email'],$_GET['reset_token']) && !empty($_GET['email']) && !empty($_GET['reset_token'])) {
  $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email AND reset_token=:reset_token');
  $stmt->execute([
    ':reset_token' => $_GET['reset_token'],
    ':email' => $_GET['email']
  ]);
  if ($stmt->rowCount()) {
    //HTML form for reset password and set action=""
    ?>

    <!----------------- html form ----------------->
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../views/css/bootstrap.rtl.min.css">
      <link rel="stylesheet" href="../views/css/style.css">
      <title>Change password | saeed shari</title>
    </head>
    <body>
      <div class="container px-4 pt-5">
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
                  <strong><?php echo $_SESSION['successful'];?></strong>
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
                      <h3>فرم تغییر رمز عبور</h3>
                  </div>
                  <div class="row gx-5 align-items-center">
                  <div class="col-md">
                  <form action="" method="post">
          
                      <div class="form-floating mb-3">
                          <input name="new_password" type="password" class="form-control" id="floatingPassword" placeholder="رمز عبور">
                          <label class="custom-label" for="floatingPassword">رمز عبور</label>
                      </div>
                      <div class="form-floating mb-3">
                          <input name="password_confirm" type="password" class="form-control" id="floatingPassword" placeholder="تکرار رمز عبور">
                          <label class="custom-label" for="floatingPassword">تکرار رمز عبور</label>
                      </div>
                      
                      <div class="d-grid gap-2">
                      <input class="btn btn-custom" type="submit" name="submit" value="تغییر رمز">
                      </div>
                  </form>
                  </div> <!-- col-md -->

                  <div class="col-md d-none d-md-block">
                  <img src="../views/images/register.svg" class="img-fluid" alt="...">
                  </div> <!-- col-md -->

                  </div> <!-- row -->
              </div> <!-- card-body -->
          </div> <!-- card -->
  </div> <!-- row -->
  </div> <!-- container -->

      <script src="../views/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php

      if (isset($_POST['new_password'],$_POST['password_confirm']) && !empty($_POST['new_password']) && !empty($_POST['password_confirm'])) {
        if ($_POST['new_password'] === $_POST['password_confirm']) {

          $stmt = $pdo->prepare('UPDATE users SET password=:password WHERE email=:email AND reset_token=:reset_token');
          $stmt->execute([
            ':reset_token' => $_GET['reset_token'],
            ':email' => $_GET['email'],
            ':password' => password_hash($_POST['new_password'],PASSWORD_DEFAULT,['cost' => 11])
          ]);
            if ($stmt->rowCount()) {
              $stmt = $pdo->prepare('UPDATE users SET reset_token=:reset_token WHERE email=:email');
              $stmt->execute([
                ':reset_token' => NULL,
                ':email' => $_GET['email']
              ]);
                if ($stmt->rowCount()) {
                  echo "تغییر رمز عبور شما با موفقیت انجام شد";
                    header('refresh:1.5 ; url=../views/login.php');
                  die();
                  
                }
            }
        }else {
          echo 'رمز عبور با تکرار رمز عبور مطابقت ندارد';
          }
      }

  }else {
    die('invalid Token');
  }
}

 ?>
