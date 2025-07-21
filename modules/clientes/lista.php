<?php
require '../../includes/db.php';

// Filtros
$buscar = $_GET['buscar'] ?? '';

// Consulta
$where = "WHERE 1=1";
if (!empty($buscar)) {
    $buscar = $conn->real_escape_string($buscar);
    $where .= " AND (nombre LIKE '%$buscar%' OR correo LIKE '%$buscar%')";
}

$resultado = $conn->query("SELECT * FROM clientes $where ORDER BY nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes - Stockea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-success">👥 Clientes</h3>
        <div class="d-flex gap-2">
            <a href="../../modules/dashboard/dashboard.php" class="btn btn-outline-secondary">← Volver al Panel</a>
            <a href="crear.php" class="btn btn-success">+ Nuevo Cliente</a>
        </div>
    </div>

    <form method="GET" class="mb-4">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o correo" value="<?= htmlspecialchars($buscar) ?>">
    </form>

    <?php if (isset($_GET['creado'])): ?>
        <div class="alert alert-success">✅ Cliente registrado correctamente.</div>
    <?php elseif (isset($_GET['editado'])): ?>
        <div class="alert alert-warning">✏️ Cliente actualizado correctamente.</div>
    <?php elseif (isset($_GET['eliminado'])): ?>
        <div class="alert alert-danger">🗑️ Cliente eliminado correctamente.</div>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td><?= htmlspecialchars($row['correo']) ?></td>
                    <td><?= htmlspecialchars($row['telefono']) ?></td>
                    <td><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td>
                        <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning">Editar</a>
                        <a href="eliminar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar cliente?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
