<?php
require __DIR__ . '/fpdf/fpdf.php';

// 1. Conexión
$conexion = new mysqli("localhost", "root", "", "stockea_db");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");

// 2. Filtros GET
$buscar = $_GET['buscar'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';

// 3. Armar condición WHERE
$where = "WHERE 1=1";

if (!empty($buscar)) {
    $buscar = $conexion->real_escape_string($buscar);
    $where .= " AND (nombre LIKE '%$buscar%' OR codigo LIKE '%$buscar%')";
}

if (!empty($categoria)) {
    $categoria = $conexion->real_escape_string($categoria);
    $where .= " AND categoria = '$categoria'";
}

if (!empty($fecha_inicio)) {
    $fecha_inicio = $conexion->real_escape_string($fecha_inicio);
    $where .= " AND fecha_ingreso >= '$fecha_inicio'";
}

if (!empty($fecha_fin)) {
    $fecha_fin = $conexion->real_escape_string($fecha_fin);
    $where .= " AND fecha_ingreso <= '$fecha_fin'";
}

// 4. Consulta filtrada
$sql = "SELECT nombre, codigo, categoria, cantidad, precio, fecha_ingreso FROM productos $where";
$resultado = $conexion->query($sql);

// 5. Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();

// 6. Encabezado del documento
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode(' Reporte de Inventario - Stockea'), 0, 1, 'C');
$pdf->Ln(8);

// 7. Encabezado de tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(50, 150, 50);
$pdf->SetTextColor(255);
$pdf->Cell(40, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
$pdf->Cell(25, 10, utf8_decode('Código'), 1, 0, 'C', true);
$pdf->Cell(30, 10, utf8_decode('Categoría'), 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Cant.', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Precio', 1, 0, 'C', true);
$pdf->Cell(40, 10, utf8_decode('Fecha Ingreso'), 1, 1, 'C', true);

// 8. Filas de productos
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0);
while ($row = $resultado->fetch_assoc()) {
    $pdf->Cell(40, 10, utf8_decode($row['nombre']), 1);
    $pdf->Cell(25, 10, utf8_decode($row['codigo']), 1);
    $pdf->Cell(30, 10, utf8_decode($row['categoria']), 1);
    $pdf->Cell(20, 10, $row['cantidad'], 1, 0, 'C');
    $pdf->Cell(25, 10, '$' . number_format($row['precio'], 2), 1, 0, 'R');
    $pdf->Cell(40, 10, $row['fecha_ingreso'], 1);
    $pdf->Ln();
}

// 9. Salida
$pdf->Output('I', 'inventario_filtrado.pdf');
exit;
