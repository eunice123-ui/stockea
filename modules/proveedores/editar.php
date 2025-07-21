<?php
require '../../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: lista.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM proveedores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    echo "Proveedor no encontrado.";
    exit;
}

$proveedor = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $empresa = $_POST['empresa'];

    $stmt = $conn->prepare("UPDATE proveedores SET nombre=?, correo=?, telefono=?, empresa=? WHERE id=?");
    $stmt->bind_param("ssssi", $nombre, $correo, $telefono, $empresa, $id);

    if ($stmt->execute()) {
        header("Location: lista.php?editado=1");
        exit;
    } else {
        $error = "Error al actualizar proveedor: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proveedor - Stockea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/proveedores.css">
</head>
<body>
<div class="container mt-5">
    <div class="form-container">
        <div class="card p-4">
            <h4 class="mb-4 text-warning text-center">✏️ Editar Proveedor</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($proveedor['nombre']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Correo:</label>
                    <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($proveedor['correo']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Teléfono:</label>
                    <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($proveedor['telefono']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Empresa:</label>
                    <input type="text" name="empresa" class="form-control" value="<?= htmlspecialchars($proveedor['empresa']) ?>">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-warning">Guardar cambios</button>
                    <a href="lista.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
