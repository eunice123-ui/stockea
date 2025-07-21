<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../modules/login/login.php");
    exit();
}

if (isset($_GET['file'])) {
    $archivo_actual = basename($_GET['file']);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nuevo_nombre = basename($_POST['nuevo_nombre']);
   rename("../../assets/uploads/" . $archivo_actual, "../../assets/uploads/" . $nuevo_nombre);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Renombrar Documento</title>
  <link rel="stylesheet" href="../../assets/css/documentos.css">
</head>
<body>
  <div class="container">
    <h2>✏️ Renombrar Documento</h2>
    <form method="POST">
      <input type="text" name="nuevo_nombre" value="<?= $archivo_actual ?>" required>
      <button type="submit">Guardar</button>
    </form>
    <a href="index.php" class="btn-back">← Cancelar</a>
  </div>
</body>
</html>
