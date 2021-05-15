<?php

session_start();

require_once('../inc/connection.php');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if (isset($_POST['nickname'],$_POST['password']) && !empty($_POST['nickname']) && !empty($_POST['password'])) {

        if (preg_match('/^[a-z\s]/i',$_POST['nickname'])) {

            if (strlen($_POST['password']) >= 8 && strlen($_POST['password']) <= 32) {

                $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
                $stmt->execute([
                        ':email'  => $_SESSION['email']
                        ]);
                if ($stmt->rowCount()) {
                    foreach($stmt->fetchAll() as $value){
                        if(password_verify($_POST['password'],$value['password'])){
                            $stmt = $pdo->prepare('UPDATE users SET nickname=:nickname WHERE email=:email');
                            $stmt->execute([
                                    ':nickname' => $_POST['nickname'],
                                    ':email'    => $_SESSION['email']
                                    ]);
                            if ($stmt->rowCount()) {
                                $_SESSION['successful'] = 'عملیات با موفقیت انجام شد';
                                header('refresh:.2 ; url=../views/nickname.php');
                            }
                        }else{
                            $_SESSION['error'] = 'رمز عبور اشتباه است';
                            header('refresh:.2 ; url=../views/nickname.php');                        }
                    }
                }else{
                    $_SESSION['error'] = 'کاربر یافت نشد';
                    header('refresh:.2 ; url=../views/nickname.php');                }
            }
        }else{
            $_SESSION['error'] = 'نام مستعار باید شامل کلمات و فاصله باشد';
            header('refresh:.2 ; url=../views/nickname.php');
        }
    }else{
        $_SESSION['error'] = 'فیلد ها خالی را پر کنید';
            header('refresh:.2 ; url=../views/nickname.php');
    }
}else{
    $_SESSION['error'] = 'شما وارد نشدید لطفا وارد حساب خود شوید';
    header('refresh:.2 ; url=../views/nickname.php');
    die();
}
?>