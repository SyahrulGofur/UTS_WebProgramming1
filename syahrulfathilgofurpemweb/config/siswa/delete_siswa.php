<?php
require_once('../../koneksi/koneksi.php');

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;

try {
    $getGambarSql = 'SELECT gambar FROM tb_siswa WHERE id = ?';
    $getGambarStmt = $db_connection->prepare($getGambarSql);
    $getGambarStmt->execute([$id]);
    $gambar = $getGambarStmt->fetchColumn();

    $deleteSql = 'DELETE FROM tb_siswa WHERE id = ?';
    $deleteStmt = $db_connection->prepare($deleteSql);
    $deleteStmt->execute([$id]);

    if (!empty($gambar)) {
        $gambarPath = '../../assets/upload/' . $gambar;
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }
    }

    echo json_encode(['success' => true]);
    header("Refresh:0");
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
