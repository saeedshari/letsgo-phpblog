<?php
session_start();

require_once('../inc/connection.php');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {

  if (isset($_POST['current_password'],$_POST['new_password'],$_POST['password_confirm']) && !empty($_POST['current_password'])
   && !empty($_POST['new_password']) && !empty($_POST['password_confirm'])) {

      if (strlen($_POST['current_password']) >= 8 && strlen($_POST['current_password']) <= 32) {

        if (strlen($_POST['new_password']) >= 8 && strlen($_POST['new_password']) <= 32) {

          if ($_POST['new_password'] === $_POST['password_confirm']) {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username=:username OR email=:email');
            $stmt->execute([
              ':username' => $_SESSION['username'],
              ':email' => $_SESSION['email']
            ]);

            if ($stmt->rowCount()) {
              foreach ($stmt->fetchAll() as $value) {
                //checks that the user has entered the password correctly
                if (password_verify($_POST['current_password'],$value['password'])) {

                  $stmt = $pdo->prepare('UPDATE users SET password=:password WHERE username=:username');
                  $stmt->execute([
                    ':password' => password_hash($_POST['new_password'],PASSWORD_DEFAULT),
                    ':username' => $_SESSION['username']
                  ]);
                    if ($stmt->rowCount()) {
                      $_SESSION['successful'] = 'رمز عبور با موفقیت ثبت شد';
                      header('refresh:.2 ; url=../views/change-password.php');  
                    }else {
                      echo "an error has occured!";
                    }

                }else {
                  $_SESSION['error'] = 'رمز عبور فعلی نامعتبر';
                  header('refresh:.2 ; url=../views/change-password.php');  
                }

              } //foreach

            }else {
              $_SESSION['error'] = 'ایمیل یا نام کاربری نامعتبر';
              header('refresh:.2 ; url=../views/change-password.php');  
            }
          }else {
            $_SESSION['error'] = 'رمز عبور با تکرار رمز عبور همخوانی ندارند';
            header('refresh:.2 ; url=../views/change-password.php');  
          }
        }

      }else {
        $_SESSION['error'] = 'لطفا رمز عبور معتبر وارد کنید';
        header('refresh:.2 ; url=../views/change-password.php');  
      }
  }else {
    $_SESSION['error'] = 'لطفا فیلد های خالی را پر کنید';
    header('refresh:.2 ; url=../views/change-password.php');  
  }
}else {
  die('you have to login');
}


 ?>
