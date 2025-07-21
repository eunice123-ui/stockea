<?php
require '../../includes/db.php';

$tipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';

// Configuración según tipo solicitado
switch ($tipo) {
    case 'clientes':
        $tabla = 'clientes';
        $nombreArchivo = 'clientes_' . date('Y-m-d') . '.csv';
        $encabezados = ['ID', 'Nombre completo', 'Correo electrónico', 'Teléfono', 'Descripción'];
        $campos = ['id', 'nombre', 'correo', 'telefono', 'descripcion'];
        break;

    case 'productos':
        $tabla = 'productos';
        $nombreArchivo = 'productos_' . date('Y-m-d') . '.csv';
        $encabezados = ['ID', 'Nombre del Producto', 'Código', 'Categoría', 'Cantidad', 'Precio', 'Fecha de ingreso', 'Descripción'];
        $campos = ['id', 'nombre', 'codigo', 'categoria', 'cantidad', 'precio', 'fecha_ingreso', 'descripcion'];
        break;

    case 'ventas':
        $tabla = 'ventas';
        $nombreArchivo = 'ventas_' . date('Y-m-d') . '.csv';
        $encabezados = ['ID', 'Fecha', 'ID Cliente', 'Total'];
        $campos = ['id', 'fecha', 'cliente_id', 'total'];
        break;

    case 'detalle_venta':
        $tabla = 'venta_detalle'; // este es el nombre real en tu BD
        $nombreArchivo = 'detalle_venta_' . date('Y-m-d') . '.csv';
        $encabezados = ['ID', 'ID Venta', 'ID Producto', 'Cantidad', 'Precio Unitario'];
        $campos = ['id', 'venta_id', 'producto_id', 'cantidad', 'precio_unitario'];
        break;

    default:
        echo "<h4 style='color: red; text-align: center; margin-top: 30px;'>❌ Tipo de exportación no válido: <code>$tipo</code><br>Verifica que el enlace o botón use el valor correcto.</h4>";
        exit();
}

// 🔒 Encabezados HTTP
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");

// ✅ BOM para que Excel muestre acentos correctamente
echo "\xEF\xBB\xBF";

$salida = fopen('php://output', 'w');
fputcsv($salida, $encabezados, ';');

// 🗃️ Consulta SQL y escritura de datos
$consulta = $conn->query("SELECT " . implode(",", $campos) . " FROM $tabla");

while ($fila = $consulta->fetch_assoc()) {
    $linea = [];
    foreach ($campos as $campo) {
        $valor = '"' . html_entity_decode($fila[$campo], ENT_QUOTES, 'UTF-8') . '"';
        $linea[] = $valor;
    }
    fputcsv($salida, $linea, ';');
}

fclose($salida);
exit();
