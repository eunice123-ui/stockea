<?php
session_start();
require '../../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_nombre = $_POST['nombre'];

    // Si el usuario subió una nueva foto
    if (!empty($_FILES['foto']['name'])) {
        $foto_nombre = uniqid() . "_" . basename($_FILES['foto']['name']);
        $ruta_destino = "../../assets/uploads/" . $foto_nombre;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino)) {
            // Actualiza base de datos
            $conn->query("UPDATE usuarios SET nombre = '$nuevo_nombre', foto = '$foto_nombre' WHERE id = $usuario_id");

            // Actualiza sesión con nueva imagen
            $_SESSION['usuario_foto'] = $foto_nombre;
        } else {
            // Si no se pudo mover, solo actualiza el nombre
            $conn->query("UPDATE usuarios SET nombre = '$nuevo_nombre' WHERE id = $usuario_id");
        }
    } else {
        // Solo se actualizó el nombre
        $conn->query("UPDATE usuarios SET nombre = '$nuevo_nombre' WHERE id = $usuario_id");
    }

    // Actualiza el nombre en sesión
    $_SESSION['usuario_nombre'] = $nuevo_nombre;

    // Redirige al dashboard
    header("Location: ../dashboard/dashboard.php");
    exit();
}

// Obtener datos actuales desde base de datos y actualizar sesión si se perdió
$usuario = $conn->query("SELECT nombre, foto FROM usuarios WHERE id = $usuario_id")->fetch_assoc();

// Refresca valores en sesión si aún no están definidos
$_SESSION['usuario_nombre'] = $_SESSION['usuario_nombre'] ?? $usuario['nombre'];
$_SESSION['usuario_foto'] = $_SESSION['usuario_foto'] ?? ($usuario['foto'] ?? 'default.png');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4">👤 Editar Perfil</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto de Perfil</label><br>
            <?php
            $foto = $usuario['foto'] ?? 'default.png';
            ?>
            <img src="../../assets/uploads/<?= htmlspecialchars($foto) ?>" width="100" class="mb-2 rounded-circle"><br>
            <input type="file" name="foto" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="../dashboard/dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
