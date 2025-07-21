<?php
include '../../includes/db.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST["correo"];
    $nombre = $_POST["nombre"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    // Validar existencia
    $verificar = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $verificar->bind_param("s", $correo);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        $message = "<div class='alert danger'>⚠️ Este correo ya está registrado.</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $correo, $password);
        if ($stmt->execute()) {
            header("Location: login.php?registro=exito");
            exit;
        } else {
            $message = "<div class='alert danger'>❌ Error al registrar. Intenta nuevamente.</div>";
        }
    }

    $verificar->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registrarse - Stockea</title>
  <link rel="stylesheet" href="../../assets/css/register.css" />
</head>
<body>
  <div class="form-container">
    <img src="../../assets/img/logo.png" class="logo" alt="Logo" />
    <h2>Crea tu cuenta</h2>
    
    <?= $message ?>

    <form method="POST" action="">
      <input type="text" name="nombre" placeholder="Nombre completo" required />
      <input type="email" name="correo" placeholder="Correo electrónico" required />
      
      <div class="password-field">
        <input type="password" name="password" id="password" placeholder="Contraseña" required />
        <span id="togglePassword">👁️</span>
      </div>
      
      <button type="submit">Registrarse</button>
      <p class="login-link">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </form>

<div class="text-center mt-3">
<a href="../../index.php" class="btn-back">← Volver al inicio</a>
</div>

  </div>

  <script src="../../assets/js/register.js"></script>
</body>
</html>
