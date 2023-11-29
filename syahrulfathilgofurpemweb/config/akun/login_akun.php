<?php
session_start();

require("read_akun.php");

$user = [
    'username' => $_POST['username'],
    'password' => $_POST['password'],
];

$not_found = false;
$_SESSION['error'] = null;

alert($user);

foreach ($data as $key => $registered_user) {
    if ($registered_user['username'] == $user['username']) {
        if ($registered_user['password'] == $user['password']) {
            $_SESSION['login'] = true;
            $_SESSION['username'] =  $user['username'];
            $_SESSION['message']  = 'Berhasil login ke dalam sistem.';
            header("Location: ../../page/main.php");
            exit();
        } else {
            $_SESSION['error'] = 'Password anda salah';
            header("Location: ../../index.php");
            exit();
        }
    }
}

$_SESSION['error'] = 'User tidak ditemukan';
header("Location: ../../index.php");
exit();