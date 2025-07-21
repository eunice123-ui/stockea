<?php
require '../../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $categoria = $_POST['categoria'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conn->prepare("INSERT INTO productos (nombre, codigo, categoria, cantidad, precio, fecha_ingreso, descripcion)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssidds", $nombre, $codigo, $categoria, $cantidad, $precio, $fecha_ingreso, $descripcion);

    if ($stmt->execute()) {
        header("Location: lista.php?exito=1");
        exit();
    } else {
        $error = "Error al guardar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Producto</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../../assets/css/productos.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Registrar Producto</h2>

    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Nombre del producto</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Código</label>
            <input type="text" name="codigo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <input type="text" name="categoria" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de ingreso</label>
            <input type="date" name="fecha_ingreso" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Guardar producto</button>
            <a href="lista.php" class="btn btn-secondary">Volver al listado</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- JS personalizado -->
<script src="../../assets/js/productos.js"></script>

</body>
</html>
