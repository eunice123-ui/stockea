<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../modules/login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
  $categoria = $_POST['categoria'] ?? '';
  if ($categoria === '') {
    die("No se seleccionó ninguna categoría.");
  }

  foreach ($_FILES['archivo']['tmp_name'] as $i => $tmpName) {
    if ($tmpName !== '') {
      $nombreOriginal = basename($_FILES['archivo']['name'][$i]);
      $nombreFinal = $categoria . '_' . $nombreOriginal;
      $rutaDestino = '../../assets/uploads/' . $nombreFinal;
      move_uploaded_file($tmpName, $rutaDestino);
    }
  }

  header("Location: index.php"); // redirección correcta
  exit();
}
?>
