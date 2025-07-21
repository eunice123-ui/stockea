<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../modules/login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario - Stockea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/calendario.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4 text-center">📅 Calendario de Actividades</h2>
        <div id="calendar" class="shadow p-3 mb-5 bg-body rounded"></div>
        <a href="../dashboard/dashboard.php" class="btn btn-outline-secondary mt-4">← Volver al Panel</a>
    </div>

    <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- Tu script -->
<script src="../../assets/js/calendario.js"></script>

</body>
</html>

