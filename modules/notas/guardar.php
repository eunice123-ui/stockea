<?php
session_start();
include '../../includes/db.php';

$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];
$categoria = $_POST['categoria'];
$color = $_POST['color'] ?? '#fffacd';
$usuario_id = $_SESSION["usuario_id"];

$stmt = $conn->prepare("INSERT INTO notas (titulo, contenido, categoria, color, usuario_id) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $titulo, $contenido, $categoria, $color, $usuario_id);
$stmt->execute();
$stmt->close();

header("Location: index.php");
exit();
?>
