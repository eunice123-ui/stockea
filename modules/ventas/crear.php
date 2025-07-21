<?php
require '../../includes/db.php';

// Obtener clientes y productos
$clientes = $conn->query("SELECT id, nombre FROM clientes");
$productos = $conn->query("SELECT id, nombre, precio FROM productos");

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $productos_seleccionados = $_POST['producto'];
    $cantidades = $_POST['cantidad'];
    $precios = $_POST['precio'];

    $total = 0;
    foreach ($productos_seleccionados as $index => $producto_id) {
        $total += $cantidades[$index] * $precios[$index];
    }

    // Insertar venta
    $stmt = $conn->prepare("INSERT INTO ventas (cliente_id, total) VALUES (?, ?)");
    $stmt->bind_param("id", $cliente_id, $total);
    $stmt->execute();
    $venta_id = $stmt->insert_id;

    // Insertar detalles
    $stmt_detalle = $conn->prepare("INSERT INTO venta_detalle (venta_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
    foreach ($productos_seleccionados as $index => $producto_id) {
        $cantidad = $cantidades[$index];
        $precio = $precios[$index];
        $stmt_detalle->bind_param("iiid", $venta_id, $producto_id, $cantidad, $precio);
        $stmt_detalle->execute();
    }

    header("Location: lista.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Venta - Stockea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function agregarProducto() {
            const fila = document.querySelector('.producto-row').cloneNode(true);
            document.getElementById('productos-container').appendChild(fila);
        }

        function eliminarProducto(btn) {
            const fila = btn.closest('.producto-row');
            if (document.querySelectorAll('.producto-row').length > 1) {
                fila.remove();
            }
        }
    </script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4 text-danger">🧾 Registrar Nueva Venta</h3>

    <form method="POST">
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">Selecciona un cliente</option>
                <?php while ($c = $clientes->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div id="productos-container">
            <div class="row g-2 align-items-end producto-row mb-2">
                <div class="col-md-5">
                    <label class="form-label">Producto</label>
                    <select name="producto[]" class="form-select" required>
                        <option value="">Selecciona un producto</option>
                        <?php
                        $productos->data_seek(0); // Reiniciar puntero
                        while ($p = $productos->fetch_assoc()):
                        ?>
                            <option value="<?= $p['id'] ?>" data-precio="<?= $p['precio'] ?>">
                                <?= htmlspecialchars($p['nombre']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad[]" class="form-control" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Precio Unitario</label>
                    <input type="number" name="precio[]" class="form-control" step="0.01" required>
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger" onclick="eliminarProducto(this)">−</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-outline-secondary mb-3" onclick="agregarProducto()">+ Agregar Producto</button>
        <br>
        <button type="submit" class="btn btn-danger">Guardar Venta</button>
        <a href="lista.php" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
