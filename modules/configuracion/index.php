<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración - Stockea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/configuracion.css?v=1.0">
</head>
<body class="bg-light">
<div class="container py-5">
    <a href="../dashboard/dashboard.php" class="btn btn-outline-success">
    <i class="bi bi-arrow-left"></i> Volver al Panel
</a>
    <h3 class="mb-4 text-center">⚙️ Configuraciones del Sistema</h3>
    <p class="text-muted text-center">Administra tus preferencias generales para personalizar tu experiencia</p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

        <!-- Idioma -->
        <div class="col">
            <div class="card opcion-card text-center shadow-sm">
                <i class="bi bi-translate fs-2 text-primary mb-2"></i>
                <h5>Cambiar idioma</h5>
                <p class="small text-muted">Selecciona tu idioma preferido</p>
                <a href="idioma.php" class="btn btn-outline-primary btn-sm w-100">Administrar</a>
            </div>
        </div>

        <!-- Tema -->
        <div class="col">
            <div class="card opcion-card text-center shadow-sm">
                <i class="bi bi-palette fs-2 text-warning mb-2"></i>
                <h5>Personalizar tema</h5>
                <p class="small text-muted">Elige colores o modo oscuro</p>
                <a href="tema.php" class="btn btn-outline-warning btn-sm w-100">Configurar</a>
            </div>
        </div>

        <!-- Exportar -->
        <div class="col">
            <div class="card opcion-card text-center shadow-sm">
                <i class="bi bi-download fs-2 text-success mb-2"></i>
                <h5>Exportar Datos</h5>
                <p class="small text-muted">Descarga respaldos de clientes o ventas</p>
                <a href="exportar.php" class="btn btn-outline-success btn-sm w-100">Descargar</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
