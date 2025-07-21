<?php
require '../../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: lista.php");
    exit;
}

$id = $_GET['id'];

// Preparamos y ejecutamos la eliminación
$stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: lista.php?eliminado=1");
exit;
?>
