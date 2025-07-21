php
<?php
include '../../includes/db.php';
$id = $_GET['id'];
$doc = $conn->query("SELECT * FROM documentos WHERE id = $id")->fetch_assoc();
if ($doc) {
    header('Content-Disposition: attachment; filename="' . $doc['nombre'] . '"');
    readfile($doc['ruta']);
    exit;
} else {
    echo "Archivo no encontrado.";
}