<?php
session_start();
include '../../includes/db.php';

$id = $_GET['id'];
$usuario_id = $_SESSION["usuario_id"];

$stmt = $conn->prepare("DELETE FROM notas WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $id, $usuario_id);
$stmt->execute();
$stmt->close();

header("Location: index.php");
exit();
?>
