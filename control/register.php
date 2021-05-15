<?php

require_once('../inc/connection.php');
session_start();
if (isset($_POST['submit'],$_POST['username'],$_POST['email'],$_POST['password'],$_POST['password_confirm'])
&& !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password_confirm = $_POST['password_confirm'];

  if (preg_match('/^[a-z0-9-_. ]*$/i',$username)) {

      if (strlen($password) >= 8 && strlen($password) <= 32) {

          if ($password_confirm === $password) {

                if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
                    $stmt = $pdo->prepare('SELECT * FROM users WHERE username=?');
                    $stmt->execute([$username]);
                    if ($stmt->rowCount()) {
                      $_SESSION['error'] = 'نام کاربری قبلا انتخاب شده است';
                      header('refresh:.2 ; url=../views/register.php');
                      die();
                    }else {
                        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=?');
                        $stmt->execute([$email]);
                        if ($stmt->rowCount()) {
                          $_SESSION['error'] = 'ایمیل قبلا انتخاب شده است';
                          header('refresh:.2 ; url=../views/register.php');
                          die();
                        }else {
                          // email and username ok
                          $stmt = $pdo->prepare('INSERT INTO users (`username`,`password`,`email`) VALUES (?,?,?)');
                          $stmt->execute([
                            $username,
                            password_hash($password,PASSWORD_DEFAULT,['cost' => 11]),
                            $email
                          ]);
                            if ($stmt->rowCount()) {
                              $_SESSION['successful'] = 'با تشکر از ثبت نام شما عملیات با موفقیت انجام شد';
                                header('refresh:.2 ; url=../views/register.php');
                            }
                        }
                    }

              }else {
                $_SESSION['error'] = 'ایمیل انتخاب شده معتبر نیست';
                header('refresh:.2 ; url=../views/register.php');
              }
          }else {
            $_SESSION['error'] = 'رمز عبور و تکرار رمز عبور همخوانی ندارد';
            header('refresh:.2 ; url=../views/register.php');
          }
      }else {
        $_SESSION['error'] = 'رمز عبور معتبر انتخاب کنید';
        header('refresh:.2 ; url=../views/register.php');
      }
  }else {
    $_SESSION['error'] = 'نام کاربری معتبر وارد کنید';
    header('refresh:.2 ; url=../views/register.php');
  }
}else{
  $_SESSION['error'] = 'فیلد خالی است لطفا فیلد ها را پر کنید';
    header('refresh:.2 ; url=../views/register.php');
}
 ?>
