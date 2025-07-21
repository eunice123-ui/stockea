<?php
require '../../includes/db.php';

$busqueda = $_GET['buscar'] ?? '';

// Consulta con filtro
$sql = "SELECT v.id, v.fecha, c.nombre AS cliente, v.total 
        FROM ventas v 
        LEFT JOIN clientes c ON v.cliente_id = c.id 
        WHERE c.nombre LIKE ? OR v.fecha LIKE ?
        ORDER BY v.fecha DESC";

$stmt = $conn->prepare($sql);
$like = "%$busqueda%";
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas - Stockea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-danger">🧾 Ventas</h3>
        <div class="d-flex gap-2">
            <a href="../dashboard/dashboard.php" class="btn btn-outline-secondary">← Volver al Panel</a>
            <a href="crear.php" class="btn btn-danger">+ Nueva Venta</a>
            <a href="../../fpdf.php?buscar=<?= urlencode($busqueda) ?>" class="btn btn-outline-dark">📄 Exportar PDF</a>
        </div>
    </div>

    <form method="GET" class="mb-3 d-flex justify-content-end">
        <input type="text" name="buscar" class="form-control w-25 me-2" placeholder="Buscar por cliente o fecha" value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit" class="btn btn-outline-primary">Buscar</button>
    </form>

    <?php if ($resultado->num_rows === 0): ?>
        <div class="alert alert-info">Aún no hay ventas registradas.</div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead class="table-danger">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['fecha'] ?></td>
                        <td><?= $row['cliente'] ?? 'Sin cliente' ?></td>
                        <td>$<?= number_format($row['total'], 2) ?></td>
                        <td>
                            <a href="detalle.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
