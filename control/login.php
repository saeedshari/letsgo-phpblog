<?php
session_start();

require_once('../inc/connection.php');

if (isset($_POST['username'],$_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (preg_match('/^[a-z0-9-_. ]*$/i',$username)) {

      if (strlen($password) >= 8 && strlen($password) <= 32) {
          $stmt = $pdo->prepare('SELECT * FROM users WHERE ( username=:username OR email=:email ) AND activated = 1');
          $stmt->execute([
                  ':username' => $username,
                  ':email'    => $username
                  ]);
          if ($stmt->rowCount()) {
            foreach ($stmt->fetchAll() as $value) {
              //checks that the user has entered the password correctly
                if (password_verify($password,$value['password'])) {
                  //wellcome user

                  $_SESSION['loggedin'] = true;
                  $_SESSION['username'] = $value['username'];
                  $_SESSION['email']    = $value['email'];
                  $_SESSION['id']       = $value['id'];
                  $_SESSION['privil']   = $value['privil'];

                  //short if in php5 not work good with ( === NULL )
                  //$_SESSION['nickname'] = ($value['nickname'] == NULL)  ?  $_SESSION['username'] : $value['nickname'];
                  
                  // NULL Operator in php7 good work with NULL values. this code is similar to the above code
                  $_SESSION['nickname'] = $value['nickname'] ?? $value['username'];
                  //here for set last login in database
                  $stmt = $pdo->prepare('UPDATE users SET last_login=:last_login WHERE username=:username');
                  $stmt->execute([
                    ':last_login' => date('Y-m-d H:i'),
                    ':username'   => $_SESSION['username']
                  ]);

                  header('refresh:.5 ; url= index.php');
                  

                }else {
                  $_SESSION['error'] = 'نام کاربری یا رمز عبور اشتباه است';
                  header('refresh:.2 ; url=../views/login.php');
                }
              }

          }else {
            $_SESSION['error'] = 'حساب کاربری پیدا نشد یا فعال نشده';
            header('refresh:.2 ; url=../views/login.php');
          }

        }else {
          $_SESSION['error'] = 'رمز عبور معتبر وارد نشده';
        header('refresh:.2 ; url=../views/login.php');
        }
  }else {
    $_SESSION['error'] = 'نام کاربری معتبر وارد کنید';
    header('refresh:.2 ; url=../views/login.php');
  }
}else{
  $_SESSION['error'] = 'فیلد خالی است لطفا فیلد ها را پر کنید';
    header('refresh:.2 ; url=../views/login.php');
}

 ?>
