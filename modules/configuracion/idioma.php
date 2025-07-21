<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}

$idiomas_disponibles = [
    'es' => 'Español 🇪🇸',
    'en' => 'English 🇺🇸',
    'fr' => 'Français 🇫🇷',
    'pt' => 'Português 🇧🇷'
];

// Guardar idioma seleccionado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_idioma = $_POST['idioma'];
    $_SESSION['idioma'] = $nuevo_idioma;
    header("Location: idioma.php");
    exit();
}

$idioma_actual = $_SESSION['idioma'] ?? 'es';
?>

<!DOCTYPE html>
<html lang="<?= $idioma_actual ?>">
<head>
    <meta charset="UTF-8">
    <title>Cambiar idioma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/idioma.css?v=1.0">
</head>
<body class="bg-light">
<div class="container py-5">
    <h3 class="mb-4 text-center">🌍 Cambiar Idioma</h3>
    <p class="text-muted text-center">Selecciona el idioma que prefieras utilizar en Stockea</p>

    <form method="POST" class="row justify-content-center">
        <div class="col-md-6">
            <select name="idioma" class="form-select mb-4">
                <?php foreach ($idiomas_disponibles as $clave => $etiqueta): ?>
                    <option value="<?= $clave ?>" <?= $clave === $idioma_actual ? 'selected' : '' ?>>
                        <?= $etiqueta ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-success w-100">Guardar idioma</button>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">← Volver</a>
        </div>
    </form>
</div>
</body>
</html>
