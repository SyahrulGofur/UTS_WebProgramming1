<?php
require('../../koneksi/koneksi.php');

$nama = $_POST['nama'];
$nim = $_POST['nim'];
$kelas = $_POST['kelas'];
$alamat = $_POST['alamat'];


if (!empty($_FILES['gambar']['name'])) {
    $uploadDir = '../../assets/upload/';
    $gambarName = generateRandomName($_FILES['gambar']['name']);
    $uploadFile = $uploadDir . $gambarName;

    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        die("Hanya file gambar JPG, JPEG, PNG, dan GIF yang diizinkan.");
    }

    if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadFile)) {
        die("Gagal mengunggah file gambar.");
    }
}

try {
    $sql = 'INSERT INTO tb_siswa (id, nama, nim, kelas, alamat, gambar) VALUES (?,?,?,?,?,?)';
    $connect = $db_connection->prepare($sql);
    $connect->execute([null, $nama, $nim, $kelas, $alamat, $gambarName]);

    header("Location: ../../page/main.php");
    exit();
} catch (PDOException $e) {
    die("Error memasukkan data : " . $e->getMessage());
}

function generateRandomName($originalName)
{
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    $randomName = bin2hex(random_bytes(8));
    return $randomName . '.' . $extension;
}
