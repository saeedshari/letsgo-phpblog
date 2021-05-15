<?php

require_once('../inc/connection.php');
session_start();

if (isset($_POST['email'],$_POST['submit']) && !empty($_POST['email'])) {
  if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
    $stmt->execute([ ':email' => $_POST['email']]);
    if ($stmt->rowCount()) {
      $stmt = $pdo->prepare('UPDATE users SET reset_token=:reset_token WHERE email=:email');
      $stmt->execute([
        ':reset_token' => sha1(uniqid('',true)) . sha1(date('Y-m-d H:i')),
        ':email' => $_POST['email']
      ]);
      if ($stmt->rowCount()) {
        $stmt = $pdo->prepare('SELECT reset_token,email FROM users WHERE email=:email');
        $stmt->execute([ ':email' => $_POST['email']]);
        if ($stmt->rowCount()) {
          foreach ($stmt->fetchAll() as $value) {
            $email = strval($value['email']);
            $token = strval($value['reset_token']);
            $_SESSION['successful'] = "../control/password-recovery.php?email=$email&reset_token=$token";
              header('refresh:.2 ; url=../views/password-reset.php');
          }
        }
      }

    }else {
      $_SESSION['error'] = 'آدرس ایمیل پیدا نشد';
    header('refresh:.2 ; url=../views/password-reset.php');
    }
  }else {
    $_SESSION['error'] = 'آدرس ایمیل معتبر نیست';
    header('refresh:.2 ; url=../views/password-reset.php');
  }

}else {
  $_SESSION['error'] = 'فیلد خالی است لطفا فیلد ها را پر کنید';
    header('refresh:.2 ; url=../views/password-reset.php');
}
 ?>
