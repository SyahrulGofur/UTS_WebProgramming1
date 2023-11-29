<?php
require_once('../../koneksi/koneksi.php');

$username_user = $_POST['username'];
$password_user = $_POST['password'];
$email_user = $_POST['email'];

if (!empty($_POST['username']) || !empty($_POST['password']) || !empty($_POST['email'])) {
    try {
        $sql = 'INSERT INTO tb_akun (id, username, password, email) VALUES (?,?,?,?)';
        $connect = $db_connection->prepare($sql);
        $connect->execute([null, $username_user, $password_user, $email_user]);
        header("Location: ../../index.php");
        exit();
    } catch (PDOException $e) {
        die("error memasukkan data : " . $e->getMessage());
    }
}
