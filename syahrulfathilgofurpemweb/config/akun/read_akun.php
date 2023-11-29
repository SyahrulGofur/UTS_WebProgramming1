<?php
require('../../koneksi/koneksi.php');

try {
    $sql = 'SELECT * FROM tb_akun';
    $connect = $db_connection->prepare($sql);
    $connect->execute();

    $data = array();
    while ($row = $connect->fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row);
    }
    echo json_encode($data);
} catch (Exception $e) {
    die("tidak dapat memuat database $db_name: " . $e->getMessage());
}
?>