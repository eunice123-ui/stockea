<?php
$host = "localhost";
$usuario = "root";
$clave = ""; // o tu contraseña si tienes una
$bd = "stockea_db";

$conn = new mysqli($host, $usuario, $clave, $bd);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}
?>
