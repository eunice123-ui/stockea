<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/includes/db.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Filtros desde GET
$buscar = $_GET['buscar'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';

// Construir cláusula WHERE
$where = "WHERE 1=1";

if (!empty($buscar)) {
    $buscar = $conn->real_escape_string($buscar);
    $where .= " AND (nombre LIKE '%$buscar%' OR codigo LIKE '%$buscar%')";
}

if (!empty($categoria)) {
    $categoria = $conn->real_escape_string($categoria);
    $where .= " AND categoria = '$categoria'";
}

if (!empty($fecha_inicio)) {
    $fecha_inicio = $conn->real_escape_string($fecha_inicio);
    $where .= " AND fecha_ingreso >= '$fecha_inicio'";
}

if (!empty($fecha_fin)) {
    $fecha_fin = $conn->real_escape_string($fecha_fin);
    $where .= " AND fecha_ingreso <= '$fecha_fin'";
}

// Consulta a la base de datos con filtros
$sql = "SELECT nombre, codigo, categoria, cantidad, precio, fecha_ingreso FROM productos $where";
$resultado = $conn->query($sql);

// Crear documento Word
$phpWord = new PhpWord();
$section = $phpWord->addSection();

// Título
$section->addTitle(" Reporte de Inventario - Stockea", 1);

// Tabla con encabezados
$table = $section->addTable();
$table->addRow();
$table->addCell(2000)->addText("Nombre");
$table->addCell(2000)->addText("Código");
$table->addCell(2000)->addText("Categoría");
$table->addCell(1000)->addText("Cantidad");
$table->addCell(1500)->addText("Precio");
$table->addCell(2000)->addText("Fecha Ingreso");

// Datos
while ($row = $resultado->fetch_assoc()) {
    $table->addRow();
    $table->addCell(2000)->addText($row['nombre']);
    $table->addCell(2000)->addText($row['codigo']);
    $table->addCell(2000)->addText($row['categoria']);
    $table->addCell(1000)->addText($row['cantidad']);
    $table->addCell(1500)->addText('$' . number_format($row['precio'], 2));
    $table->addCell(2000)->addText($row['fecha_ingreso']);
}

// Nombre y descarga
$filename = "productos_" . date("Ymd_His") . ".docx";
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");

$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save("php://output");
exit;
