<?php
$host = 'localhost';
$db   = 'traffic_violation';
$user = 'root';
$pass = '';           // thay bằng password của bạn

try {
    $pdo = new PDO("mysql:host=localhost;port=3307;dbname=traffic_violation;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
?>