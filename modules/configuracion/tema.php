<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}

$temas_disponibles = [
    'claro' => 'Claro 🌞',
    'oscuro' => 'Oscuro 🌙',
    'verde' => 'Verde 🌿',
    'azul' => 'Azul 💧'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tema_seleccionado = $_POST['tema'];
    $_SESSION['tema'] = $tema_seleccionado;
    header("Location: tema.php");
    exit();
}

$tema_actual = $_SESSION['tema'] ?? 'claro';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Personalizar Tema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/tema.css?v=1.0">
</head>
<body class="bg-light">
<div class="container py-5">
    <h3 class="mb-4 text-center">🎨 Personalizar Tema</h3>
    <p class="text-muted text-center">Selecciona el estilo visual que más te guste</p>

    <form method="POST" class="row justify-content-center">
        <div class="col-md-6">
            <select name="tema" class="form-select mb-4">
                <?php foreach ($temas_disponibles as $clave => $nombre): ?>
                    <option value="<?= $clave ?>" <?= $clave === $tema_actual ? 'selected' : '' ?>>
                        <?= $nombre ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-warning w-100">Aplicar Tema</button>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">← Volver</a>
        </div>
    </form>
</div>
</body>
</html>
