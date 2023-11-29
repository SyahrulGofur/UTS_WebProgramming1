<?php
require('../koneksi/koneksi.php');

function getItemById($itemId)
{
    global $db_connection;

    try {
        $sql = 'SELECT * FROM tb_siswa WHERE id = :itemId';
        $connect = $db_connection->prepare($sql);
        $connect->bindParam(':itemId', $itemId, PDO::PARAM_INT);
        $connect->execute();

        $data = $connect->fetch(PDO::FETCH_ASSOC);

        return $data;
    } catch (Exception $e) {
        die("Tidak dapat memuat data dari database: " . $e->getMessage());
    }
}
