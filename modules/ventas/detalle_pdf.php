<?php
require '../../includes/db.php';
require '../../fpdf/fpdf.php';

if (!isset($_GET['id'])) {
    die("ID de venta no proporcionado.");
}

$venta_id = $_GET['id'];

// Obtener datos de la venta
$stmt = $conn->prepare("SELECT v.id, v.fecha, v.total, c.nombre AS cliente 
                        FROM ventas v 
                        LEFT JOIN clientes c ON v.cliente_id = c.id 
                        WHERE v.id = ?");
$stmt->bind_param("i", $venta_id);
$stmt->execute();
$venta = $stmt->get_result()->fetch_assoc();

if (!$venta) {
    die("Venta no encontrada.");
}

// Obtener productos vendidos
$stmt_detalle = $conn->prepare("SELECT p.nombre, d.cantidad, d.precio_unitario 
                                FROM venta_detalle d 
                                JOIN productos p ON d.producto_id = p.id 
                                WHERE d.venta_id = ?");
$stmt_detalle->bind_param("i", $venta_id);
$stmt_detalle->execute();
$detalles = $stmt_detalle->get_result();

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode("Detalle de Venta #{$venta['id']}"), 0, 1, 'C');
$pdf->Ln(5);

// Datos generales
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 8, 'Cliente: ' . utf8_decode($venta['cliente']), 0, 1);
$pdf->Cell(0, 8, 'Fecha: ' . $venta['fecha'], 0, 1);
$pdf->Cell(0, 8, 'Total: $' . number_format($venta['total'], 2), 0, 1);
$pdf->Ln(5);

// Tabla de productos
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(220, 53, 69);
$pdf->SetTextColor(255);
$pdf->Cell(80, 8, 'Producto', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Cantidad', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Precio Unitario', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Subtotal', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);
while ($row = $detalles->fetch_assoc()) {
    $subtotal = $row['cantidad'] * $row['precio_unitario'];
    $pdf->Cell(80, 8, utf8_decode($row['nombre']), 1);
    $pdf->Cell(30, 8, $row['cantidad'], 1, 0, 'C');
    $pdf->Cell(40, 8, '$' . number_format($row['precio_unitario'], 2), 1, 0, 'R');
    $pdf->Cell(40, 8, '$' . number_format($subtotal, 2), 1, 1, 'R');
}

$pdf->Output('I', "detalle_venta_{$venta['id']}.pdf");
exit();
