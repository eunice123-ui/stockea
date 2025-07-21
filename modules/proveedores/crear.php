<?php
require '../../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar datos del formulario
    $nombre   = $_POST['nombre'];
    $correo   = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $empresa  = $_POST['empresa'];

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("INSERT INTO proveedores (nombre, correo, telefono, empresa) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $telefono, $empresa);

    if ($stmt->execute()) {
        // Redirigir al listado con mensaje de éxito
        header("Location: lista.php?creado=1");
        exit;
    } else {
        $error = "Error al registrar proveedor: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Proveedor - Stockea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/proveedores.css">
</head>
<body>
<div class="container mt-5">
    <div class="form-container">
        <div class="card p-4">
            <h4 class="mb-4 text-warning text-center">🚚 Registrar Proveedor</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

           <form method="POST">
    <div class="mb-3">
        <label class="form-label">Nombre:</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Correo:</label>
        <input type="email" name="correo" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Teléfono:</label>
        <input type="text" name="telefono" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Empresa:</label>
        <input type="text" name="empresa" class="form-control">
    </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-warning">Guardar</button>
                    <a href="lista.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
