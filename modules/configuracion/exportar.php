<?php
session_start();
require '../../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Exportar Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h3 class="mb-4 text-center">📥 Exportar Datos</h3>
    <p class="text-muted text-center">Selecciona qué registros deseas descargar como Excel (CSV)</p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">

        <!-- Exportar clientes -->
        <div class="col">
            <div class="card text-center p-3 shadow-sm h-100">
                <i class="bi bi-people fs-2 text-info mb-2"></i>
                <h5>Clientes</h5>
                <p class="small text-muted">Descarga la lista completa de clientes</p>
                <a href="generar_csv.php?tipo=clientes" class="btn btn-outline-info btn-sm w-100">Exportar CSV</a>
            </div>
        </div>

        <!-- Exportar ventas -->
        <div class="col">
            <div class="card text-center p-3 shadow-sm h-100">
                <i class="bi bi-receipt fs-2 text-danger mb-2"></i>
                <h5>Ventas</h5>
                <p class="small text-muted">Historial de ventas registradas</p>
                <a href="generar_csv.php?tipo=ventas" class="btn btn-outline-danger btn-sm w-100">Exportar CSV</a>
            </div>
        </div>

        <!-- Exportar productos -->
        <div class="col">
            <div class="card text-center p-3 shadow-sm h-100">
                <i class="bi bi-box-seam fs-2 text-success mb-2"></i>
                <h5>Productos</h5>
                <p class="small text-muted">Todos los productos con sus detalles</p>
                <a href="generar_csv.php?tipo=productos" class="btn btn-outline-success btn-sm w-100">Exportar CSV</a>
            </div>
        </div>

        <!-- Exportar detalle de venta -->
        <div class="col">
            <div class="card text-center p-3 shadow-sm h-100">
                <i class="bi bi-list-check fs-2 text-warning mb-2"></i>
                <h5>Detalle de Venta</h5>
                <p class="small text-muted">Productos incluidos en cada venta</p>
                <a href="generar_csv.php?tipo=detalle_venta" class="btn btn-outline-warning btn-sm w-100">Exportar CSV</a>
            </div>
        </div>
    </div>

    <!-- Botón para volver al panel -->
    <div class="text-center mt-5">
        <a href="../dashboard/dashboard.php" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Volver al Panel
        </a>
    </div>
</div>
</body>
</html>
