<?php
require '../../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: lista.php");
    exit;
}

$id = $_GET['id'];

// Ejecutar eliminación
$stmt = $conn->prepare("DELETE FROM proveedores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: lista.php?eliminado=1");
exit;
