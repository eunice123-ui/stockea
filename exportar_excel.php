<?php
require __DIR__ . '/vendor/autoload.php'; // Carga PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "stockea_db");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Filtros GET
$buscar = $_GET['buscar'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';

// Construir consulta con filtros
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

// Consultar productos
$sql = "SELECT nombre, codigo, categoria, cantidad, precio, fecha_ingreso FROM productos $where";
$result = $conn->query($sql);

// Crear documento de Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$sheet->setCellValue('A1', 'Nombre');
$sheet->setCellValue('B1', 'Código');
$sheet->setCellValue('C1', 'Categoría');
$sheet->setCellValue('D1', 'Cantidad');
$sheet->setCellValue('E1', 'Precio');
$sheet->setCellValue('F1', 'Fecha Ingreso');

// Llenar filas con datos
$fila = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $fila, $row['nombre']);
    $sheet->setCellValue('B' . $fila, $row['codigo']);
    $sheet->setCellValue('C' . $fila, $row['categoria']);
    $sheet->setCellValue('D' . $fila, $row['cantidad']);
    $sheet->setCellValue('E' . $fila, $row['precio']);
    $sheet->setCellValue('F' . $fila, $row['fecha_ingreso']);
    $fila++;
}

// Descargar el archivo
$filename = "productos_" . date("Ymd_His") . ".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
