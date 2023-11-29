<?php
require('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['id'];
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];


    if ($_FILES['gambar']['size'] > 0) {
        $item_gambar = $_FILES['gambar']['name'];
        $randomFileName = generateRandomName($item_gambar);
        $uploadDir = '../../assets/upload/';
        $uploadFile = $uploadDir . $randomFileName;

        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
            die('Gagal upload gara gara file nya ga sesuai');
            // alert("Hanya file gambar JPG, JPEG, PNG, dan GIF yang diizinkan");
            // header("Location: ../../page/main.php");
        }

        try {
            $sqlGetOldImage = 'SELECT gambar FROM tb_siswa WHERE id = ?';
            $stmtGetOldImage = $db_connection->prepare($sqlGetOldImage);
            $stmtGetOldImage->execute([$itemId]);
            $oldImage = $stmtGetOldImage->fetchColumn();

            if (!empty($oldImage)) {
                $oldImagePath = '../../assets/upload/' . $oldImage;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                } else {
                    die("File lama tidak ditemukan: $oldImagePath");
                }
            }
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadFile)) {
                updateItemWithImage($itemId, $nama, $nim, $kelas, $alamat, $randomFileName);
            } else {
                die('Gagal upload file');
                // alert("Gagal upload");
                // header("Location: ../../page/main.php");
            }
        } catch (PDOException $e) {
            die("Error memperbarui data : " . $e->getMessage());
        }
    } else {
        updateItemWithoutImage($itemId, $nama, $nim, $kelas, $alamat);
    }
} else {
    header("Location: ../../page/main.php");
    exit();
}

function updateItemWithImage($itemId, $nama, $nim, $kelas, $alamat, $item_gambar)
{
    global $db_connection;

    try {
        $sqlUpdate = 'UPDATE tb_siswa SET gambar = ?, nama = ?, nim = ?, kelas = ?, alamat = ? WHERE id = ?';
        $stmtUpdate = $db_connection->prepare($sqlUpdate);
        $stmtUpdate->execute([$item_gambar, $nama, $nim, $kelas, $alamat, $itemId]);

        header("Location: ../../page/main.php");
        exit();
    } catch (PDOException $e) {
        die("Error memperbarui data : " . $e->getMessage());
    }
}



function updateItemWithoutImage($itemId, $nama, $nim, $kelas, $alamat)
{
    global $db_connection;

    try {
        $sql = 'UPDATE tb_siswa SET nama = ?, nim = ?, kelas = ?, alamat = ? WHERE id = ?';
        $connect = $db_connection->prepare($sql);
        $connect->execute([$nama, $nim, $kelas, $alamat, $itemId]);
        alert("update gapake gambar");
        header("Location: ../../page/main.php");
        exit();
    } catch (PDOException $e) {
        die("Error memperbarui data : " . $e->getMessage());
    }
}

function generateRandomName($originalName)
{
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    $randomName = bin2hex(random_bytes(8));
    return $randomName . '.' . $extension;
}
