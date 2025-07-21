<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../login/login.php");
    exit();
}
$usuario_id = $_SESSION["usuario_id"];
include '../../includes/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Notas</title>
    <link rel="stylesheet" href="../../assets/css/notas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
    <a href="../dashboard/dashboard.php" class="btn btn-outline-dark rounded-pill mb-4">
  <i class="bi bi-arrow-left-circle"></i> Volver al Panel
</a>
    <div class="container">
        <h2 class="mb-4"><i class="bi bi-journal-text"></i> Mis Notas</h2>

        <!-- FORMULARIO NUEVA NOTA -->
        <form action="guardar.php" method="POST" class="row g-2 mb-4">
            <input type="hidden" name="color" value="#fef9c3">
            <div class="col-md-3">
                <input name="titulo" class="form-control" placeholder="Título de la nota" required>
            </div>
            <div class="col-md-4">
                <textarea name="contenido" class="form-control" placeholder="Contenido..." required></textarea>
            </div>
            <div class="col-md-3">
                <select name="categoria" class="form-select">
                    <option value="Personal">Personal</option>
                    <option value="Trabajo">Trabajo</option>
                    <option value="Ideas">Ideas</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success w-100"><i class="bi bi-plus-circle"></i> Guardar</button>
            </div>
        </form>

        <!-- BÚSQUEDA -->
        <div class="mb-3">
            <input type="text" id="buscar" class="form-control" placeholder="🔍 Buscar nota por título o contenido...">
        </div>

        <!-- CONTENEDOR DE NOTAS -->
        <div id="notasContainer" class="row g-3">
            <!-- Las notas aparecerán aquí vía AJAX -->
        </div>
    </div>

<script>
document.getElementById('buscar').addEventListener('keyup', function () {
    const query = this.value;
    fetch('buscar.php?q=' + encodeURIComponent(query))
        .then(res => res.text())
        .then(html => document.getElementById('notasContainer').innerHTML = html);
});
window.onload = () => document.getElementById('buscar').dispatchEvent(new Event('keyup'));
</script>
</body>
</html>
