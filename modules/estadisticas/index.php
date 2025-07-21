<?php
require '../../includes/db.php';

// Totales
$total_productos = $conn->query("SELECT COUNT(*) AS total FROM productos")->fetch_assoc()['total'];
$total_clientes = $conn->query("SELECT COUNT(*) AS total FROM clientes")->fetch_assoc()['total'];
$total_ventas = $conn->query("SELECT COUNT(*) AS total FROM ventas")->fetch_assoc()['total'];
$total_ingresos = $conn->query("SELECT SUM(total) AS total FROM ventas")->fetch_assoc()['total'] ?? 0;

// Ventas por mes (últimos 12 meses)
$ventas_por_mes = $conn->query("
    SELECT DATE_FORMAT(fecha, '%Y-%m') AS mes, SUM(total) AS total
    FROM ventas
    GROUP BY mes
    ORDER BY mes DESC
    LIMIT 12
");

$meses = [];
$totales = [];

while ($row = $ventas_por_mes->fetch_assoc()) {
    $meses[] = $row['mes'];
    $totales[] = $row['total'];
}

$meses = array_reverse($meses);
$totales = array_reverse($totales);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas - Stockea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/estadisticas.css?v=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="../dashboard/dashboard.php" class="btn btn-outline-secondary">← Volver al Panel</a>
        <h3 class="text-success mb-0">📊 Estadísticas Generales</h3>
        <div></div>
    </div>

    <p class="text-muted text-center mb-4">
        Aquí puedes ver un resumen general del estado de tu negocio: productos disponibles, clientes registrados, ventas realizadas y los ingresos generados.
    </p>

    <!-- Tarjetas -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card resumen-card bg-primary text-white shadow text-center">
                <div class="card-body">
                    <i class="bi bi-box-seam fs-1 mb-2"></i>
                    <h5 class="card-title">Productos</h5>
                    <p class="display-6"><?= $total_productos ?></p>
                    <p class="small text-white-50">Productos activos en inventario</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card resumen-card bg-info text-white shadow text-center">
                <div class="card-body">
                    <i class="bi bi-people fs-1 mb-2"></i>
                    <h5 class="card-title">Clientes</h5>
                    <p class="display-6"><?= $total_clientes ?></p>
                    <p class="small text-white-50">Clientes registrados en el sistema</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card resumen-card bg-danger text-white shadow text-center">
                <div class="card-body">
                    <i class="bi bi-receipt fs-1 mb-2"></i>
                    <h5 class="card-title">Ventas</h5>
                    <p class="display-6"><?= $total_ventas ?></p>
                    <p class="small text-white-50">Ventas realizadas hasta la fecha</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card resumen-card bg-success text-white shadow text-center">
                <div class="card-body">
                    <i class="bi bi-cash-coin fs-1 mb-2"></i>
                    <h5 class="card-title">Ingresos</h5>
                    <p class="display-6">$<?= number_format($total_ingresos, 2) ?></p>
                    <p class="small text-white-50">Ingresos totales acumulados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfica -->
    <div class="mt-5">
        <h5 class="text-center mb-3">📅 Ventas por Mes</h5>
        <canvas id="graficaVentas" height="100"></canvas>
    </div>
</div>

<script>
    const ctx = document.getElementById('graficaVentas').getContext('2d');
    const graficaVentas = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($meses) ?>,
            datasets: [{
                label: 'Total de Ventas ($)',
                data: <?= json_encode($totales) ?>,
                backgroundColor: 'rgba(25, 135, 84, 0.7)',
                borderColor: 'rgba(25, 135, 84, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => '$' + value
                    }
                }
            }
        }
    });
</script>
</body>
</html>
