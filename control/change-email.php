<?php
session_start();

require_once('../inc/connection.php');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {

  if (isset($_POST['email'],$_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {

      if (strlen($_POST['password']) >= 8 && strlen($_POST['password']) <= 32) {

        if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {

          $stmt = $pdo->prepare('SELECT * FROM users WHERE username=:username');
          $stmt->execute([':username' => $_SESSION['username']]);

          if ($stmt->rowCount()) {
              //user available
              foreach ($stmt->fetchAll() as $value) {
                  //checks that the user has entered the password correctly
                  if (password_verify($_POST['password'],$value['password'])) {
                    //check email pick up another one
                      $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
                      $stmt->execute([':email' => $_POST['email']]);

                      if ($stmt->rowCount()) {

                        echo "Email already taken pick up another one";

                      }else {

                          $stmt = $pdo->prepare('UPDATE users SET email=:email WHERE username=:username AND id=:id');
                          $stmt->execute([
                            ':email' => $_POST['email'],
                            ':username' => $_SESSION['username'],
                            ':id' => $_SESSION['id']
                          ]);

                          if ($stmt->rowCount()) {

                            $_SESSION['successful'] = 'تغییر ایمیل با موفقیت انجام شد';
                            header('refresh:.2 ; url=../views/change-email.php');

                          }else {
                            $_SESSION['error'] = 'مشکلی در تغییر ایمیل پیش آمد';
                            header('refresh:.2 ; url=../views/change-email.php');
                          }
                      }

                  }else {
                    $_SESSION['error'] = 'رمز عبور شما نامعتبراست';
                    header('refresh:.2 ; url=../views/change-email.php');
                  }
              }

          }else {
            $_SESSION['error'] = 'نام کاربری نامعتبر است';
            header('refresh:.2 ; url=../views/change-email.php');
          }

        }else {
          $_SESSION['error'] = 'لطفا ایمیل معتبر وارد کنید';
          header('refresh:.2 ; url=../views/change-email.php');
        }

      }else {
        $_SESSION['error'] = 'رمز عبور نامعتبر است';
        header('refresh:.2 ; url=../views/change-email.php');
      }
  }else {
    $_SESSION['error'] = 'لطفا فیلد های خالی را پر کنید';
    header('refresh:.2 ; url=../views/change-email.php');
  }
}else {
  $_SESSION['error'] = 'شما وارد نشدید لطفا وارد حساب خود شوید';
  header('refresh:.2 ; url=../views/change-email.php');
  die();
}

?>
