<?php

try {
    $pdo = new PDO('mysql:dbname=min-admin;host=localhost;charset=utf8','root','',array(
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false,
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));

} catch (PDOException $e) {

    die(print_r($e->getMessage()));
}


 ?>
