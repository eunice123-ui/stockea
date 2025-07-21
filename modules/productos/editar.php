<?php
require '../../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: lista.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    echo "Producto no encontrado.";
    exit;
}

$producto = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $categoria = $_POST['categoria'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conn->prepare("UPDATE productos SET nombre=?, codigo=?, categoria=?, cantidad=?, precio=?, fecha_ingreso=?, descripcion=? WHERE id=?");
    $stmt->bind_param("sssiddsi", $nombre, $codigo, $categoria, $cantidad, $precio, $fecha_ingreso, $descripcion, $id);
    
    if ($stmt->execute()) {
        header("Location: lista.php?editado=1");
        exit;
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto - Stockea</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../../assets/css/editar.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="mb-4 text-success">✏️ Editar producto</h3>

    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Código:</label>
            <input type="text" name="codigo" class="form-control" value="<?= htmlspecialchars($producto['codigo']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Categoría:</label>
            <input type="text" name="categoria" class="form-control" value="<?= htmlspecialchars($producto['categoria']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Cantidad:</label>
            <input type="number" name="cantidad" class="form-control" value="<?= $producto['cantidad'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Precio:</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de ingreso:</label>
            <input type="date" name="fecha_ingreso" class="form-control" value="<?= $producto['fecha_ingreso'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <a href="lista.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- JS personalizado -->
<script src="../../assets/js/editar.js"></script>

</body>
</html>
