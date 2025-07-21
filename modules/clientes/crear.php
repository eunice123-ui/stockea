<?php
require '../../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $descripcion = $_POST['descripcion'];

    // Verifica que la conexión y la consulta estén bien
    $sql = "INSERT INTO clientes (nombre, correo, telefono, descripcion) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en prepare(): " . $conn->error);
    }

    // Asegúrate de que estás pasando 4 variables
    $stmt->bind_param("ssss", $nombre, $correo, $telefono, $descripcion);

    if ($stmt->execute()) {
        header("Location: lista.php?creado=1");
        exit;
    } else {
        $error = "Error al registrar cliente: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cliente - Stockea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/clientes.css">
</head>
<body>
<div class="container mt-5">
    <div class="form-container">
        <div class="card p-4">
            <h4 class="mb-4 text-success text-center">📝 Registrar Cliente</h4>

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
                    <label class="form-label">Descripción:</label>
                    <textarea name="descripcion" class="form-control" rows="3"></textarea>
               </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="lista.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
