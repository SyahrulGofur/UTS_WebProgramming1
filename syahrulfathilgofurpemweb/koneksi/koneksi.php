<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db_name = "db_web_syahrulfathilgofur";
$port = 3306;

try {
    $db_connection = new PDO("mysql:host=$hostname;port=$port;dbname=$db_name", $username, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}
function alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
