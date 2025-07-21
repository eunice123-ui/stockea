<?php
require 'includes/db.php';
require 'fpdf/fpdf.php';

$busqueda = $_GET['buscar'] ?? '';
$like = "%$busqueda%";

$sql = "SELECT v.id, v.fecha, c.nombre AS cliente, v.total 
        FROM ventas v 
        LEFT JOIN clientes c ON v.cliente_id = c.id 
        WHERE c.nombre LIKE ? OR v.fecha LIKE ?
        ORDER BY v.fecha DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$resultado = $stmt->get_result();

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Ventas - Stockea', 0, 1, 'C');
$pdf->Ln(5);

// Encabezados
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(220, 53, 69); // rojo Bootstrap
$pdf->SetTextColor(255);
$pdf->Cell(20, 8, 'ID', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Fecha', 1, 0, 'C', true);
$pdf->Cell(80, 8, 'Cliente', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Total', 1, 1, 'C', true);

// Filas
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);
while ($row = $resultado->fetch_assoc()) {
    $pdf->Cell(20, 8, $row['id'], 1);
    $pdf->Cell(40, 8, $row['fecha'], 1);
    $pdf->Cell(80, 8, $row['cliente'] ?? 'Sin cliente', 1);
    $pdf->Cell(30, 8, '$' . number_format($row['total'], 2), 1, 1);
}

$pdf->Output('I', 'ventas_stockea.pdf');
exit();
