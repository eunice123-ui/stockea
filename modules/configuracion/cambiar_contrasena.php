<?php
session_start();
require '../../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actual = $_POST['actual'];
    $nueva = $_POST['nueva'];

    $usuario = $conn->query("SELECT contrasena FROM usuarios WHERE id = $usuario_id")->fetch_assoc();

    if (password_verify($actual, $usuario['contrasena'])) {
        $hash = password_hash($nueva, PASSWORD_DEFAULT);
        $conn->query("UPDATE usuarios SET contrasena = '$hash' WHERE id = $usuario_id");
        header("Location: ../dashboard/dashboard.php");
        exit();
    } else {
        $error = "La contraseña actual es incorrecta.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4">🔒 Cambiar Contraseña</h3>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Contraseña Actual</label>
            <input type="password" name="actual" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nueva Contraseña</label>
            <input type="password" name="nueva" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning">Actualizar Contraseña</button>
        <a href="../dashboard/dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
