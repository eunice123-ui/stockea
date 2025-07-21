<?php
require '../../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: lista.php");
    exit();
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
    echo "<div class='alert alert-danger'>Venta no encontrada.</div>";
    exit();
}

// Obtener productos vendidos
$stmt_detalle = $conn->prepare("SELECT p.nombre, d.cantidad, d.precio_unitario 
                                FROM venta_detalle d 
                                JOIN productos p ON d.producto_id = p.id 
                                WHERE d.venta_id = ?");
$stmt_detalle->bind_param("i", $venta_id);
$stmt_detalle->execute();
$detalles = $stmt_detalle->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Venta - Stockea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">

    <!-- Encabezado con botones -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="lista.php" class="btn btn-outline-secondary">← Volver a la lista</a>
        <h3 class="text-danger mb-0">🧾 Detalle de Venta #<?= $venta['id'] ?></h3>
        <a href="detalle_pdf.php?id=<?= $venta['id'] ?>" class="btn btn-outline-dark">📄 Exportar Detalle en PDF</a>
    </div>

    <!-- Información general -->
    <div class="mb-3">
        <strong>Cliente:</strong> <?= htmlspecialchars($venta['cliente']) ?><br>
        <strong>Fecha:</strong> <?= $venta['fecha'] ?><br>
        <strong>Total:</strong> $<?= number_format($venta['total'], 2) ?>
    </div>

    <!-- Tabla de productos -->
    <h5 class="mt-4">Productos Vendidos</h5>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $detalles->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td><?= $row['cantidad'] ?></td>
                    <td>$<?= number_format($row['precio_unitario'], 2) ?></td>
                    <td>$<?= number_format($row['cantidad'] * $row['precio_unitario'], 2) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
