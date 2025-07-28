<?php
$host = $_ENV['DB_HOST'];
$usuario = $_ENV['DB_USER'];
$clave = $_ENV['DB_PASSWORD'];
$bd = $_ENV['DB_NAME'];
$port = $_ENV['DB_PORT'];

$conn = new mysqli($host, $usuario, $clave, $bd, $port);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}
?>
