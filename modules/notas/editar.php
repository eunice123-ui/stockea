<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login/login.php");
    exit;
}

include '../../includes/db.php';
$usuario_id = $_SESSION["usuario_id"];
$mensaje = "";

// Obtener ID
$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Editar nota
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];

    $stmt = $conn->prepare("UPDATE notas SET titulo = ?, contenido = ? WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ssii", $titulo, $contenido, $id, $usuario_id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit;
}

// Obtener nota
$stmt = $conn->prepare("SELECT * FROM notas WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $id, $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$nota = $resultado->fetch_assoc();

if (!$nota) {
    echo "❌ Nota no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Nota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
  <div class="container">
    <a href="index.php" class="text-decoration-none mb-3 d-inline-block"><i class="bi bi-arrow-left"></i> Volver a Notas</a>
    <h2 class="mb-4">Editar Nota</h2>

    <form method="POST" class="bg-white p-4 rounded shadow-sm">
      <div class="mb-3">
        <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($nota['titulo']) ?>" required>
      </div>
      <div class="mb-3">
        <textarea name="contenido" class="form-control" rows="5" required><?= htmlspecialchars($nota['contenido']) ?></textarea>
      </div>
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar Cambios</button>
    </form>
  </div>
</body>
</html>
