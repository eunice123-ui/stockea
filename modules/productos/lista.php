<?php
require '../../includes/db.php';

// Filtros
$buscar = $_GET['buscar'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';

// Paginación
$limite = 10;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $limite;

// Construir consulta dinámica
$where = "WHERE 1=1";

if (!empty($buscar)) {
    $buscar = $conn->real_escape_string($buscar);
    $where .= " AND (nombre LIKE '%$buscar%' OR codigo LIKE '%$buscar%')";
}

if (!empty($categoria)) {
    $categoria = $conn->real_escape_string($categoria);
    $where .= " AND categoria = '$categoria'";
}

if (!empty($fecha_inicio)) {
    $where .= " AND fecha_ingreso >= '$fecha_inicio'";
}

if (!empty($fecha_fin)) {
    $where .= " AND fecha_ingreso <= '$fecha_fin'";
}

// Total de productos
$totalConsulta = $conn->query("SELECT COUNT(*) AS total FROM productos $where");
$totalProductos = $totalConsulta->fetch_assoc()['total'];
$totalPaginas = ceil($totalProductos / $limite);

// Consulta paginada
$resultado = $conn->query("SELECT * FROM productos $where LIMIT $inicio, $limite");

// Categorías para el filtro
$categoriasQuery = $conn->query("SELECT DISTINCT categoria FROM productos ORDER BY categoria ASC");

// Parámetros para exportación
$parametros = http_build_query([
    'buscar' => $buscar,
    'categoria' => $categoria,
    'fecha_inicio' => $fecha_inicio,
    'fecha_fin' => $fecha_fin
]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../../assets/css/lista.css">
</head>

<body>
<div class="container mt-4 p-4 shadow rounded bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">📋 Listado de Productos</h2>
        <a href="../dashboard/dashboard.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle"></i> Volver al Panel
        </a>
    </div>

    <?php if (isset($_GET['exito'])): ?>
        <div class="alert alert-success">✅ Producto guardado correctamente.</div>
    <?php endif; ?>

    <!-- Formulario de Filtros -->
    <form class="row g-3 mb-4 align-items-end" method="GET">
        <div class="col-md-3">
            <label for="buscar" class="form-label">Buscar</label>
            <input type="text" name="buscar" id="buscar" class="form-control" placeholder="Nombre o código" value="<?= htmlspecialchars($buscar) ?>">
        </div>

        <div class="col-md-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select name="categoria" id="categoria" class="form-select">
                <option value="">Todas las categorías</option>
                <?php while ($cat = $categoriasQuery->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($cat['categoria']) ?>" <?= ($categoria === $cat['categoria']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['categoria']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-2">
            <label for="fecha_inicio" class="form-label">Desde</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?= htmlspecialchars($fecha_inicio) ?>">
        </div>

        <div class="col-md-2">
            <label for="fecha_fin" class="form-label">Hasta</label>
            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?= htmlspecialchars($fecha_fin) ?>">
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
            <a href="lista.php" class="btn btn-outline-secondary w-100">Limpiar</a>
        </div>
    </form>

    <!-- Botones de acción -->
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
        <a href="crear.php" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </a>

        <div class="d-flex gap-2">
            <a href="../../exportar_pdf.php?<?= $parametros ?>" class="btn btn-outline-danger" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill"></i> Exportar a PDF
            </a>
            <a href="../../exportar_excel.php?<?= $parametros ?>" class="btn btn-outline-success" target="_blank">
                <i class="bi bi-file-earmark-excel-fill"></i> Exportar a Excel
            </a>
            <a href="../../exportar_word.php?<?= $parametros ?>" class="btn btn-outline-primary" target="_blank">
                <i class="bi bi-file-earmark-word-fill"></i> Exportar a Word
            </a>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Fecha Ingreso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado->num_rows > 0): ?>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                            <td><?= htmlspecialchars($row['codigo']) ?></td>
                            <td><?= htmlspecialchars($row['categoria']) ?></td>
                            <td><?= $row['cantidad'] ?></td>
                            <td>$<?= number_format($row['precio'], 2) ?></td>
                            <td><?= $row['fecha_ingreso'] ?></td>
                            <td>
                                <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                                <a href="eliminar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar producto?')">
                                    <i class="bi bi-trash-fill"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">No se encontraron productos.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <?php if ($totalPaginas > 1): ?>
        <nav>
            <ul class="pagination justify-content-center mt-4">
                <?php if ($pagina > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina - 1])) ?>">Anterior</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($pagina < $totalPaginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina + 1])) ?>">Siguiente</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS personalizado -->
<script src="../../assets/js/lista.js"></script>
</body>
</html>
