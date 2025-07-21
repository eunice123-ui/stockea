<?php
session_start();
include '../../includes/db.php';

$message = "";

// Si viene un mensaje de éxito del registro
if (isset($_GET["registro"]) && $_GET["registro"] === "exito") {
    $message = "<div class='alert success'>✅ Registro exitoso. Ahora puedes iniciar sesión.</div>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST["correo"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, nombre, password FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if (password_verify($password, $usuario["password"])) {
            // Iniciar sesión
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nombre"] = $usuario["nombre"];
            $_SESSION['usuario_foto'] = $usuario['foto'];
            
           header("Location: ../dashboard/dashboard.php");
            exit();
        } else {
            $message = "<div class='alert danger'>❌ Contraseña incorrecta.</div>";
        }
    } else {
        $message = "<div class='alert danger'>❌ El correo no está registrado.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión - Stockea</title>
  <link rel="stylesheet" href="../../assets/css/login.css">
</head>
<body>
  <div class="form-container">
    <img src="../../assets/img/logo.png" class="logo" alt="Logo" />
    <h2>Iniciar Sesión</h2>

    <?= $message ?>

    <form method="POST" action="">
      <input type="email" name="correo" placeholder="Correo electrónico" required>
      
      <div class="password-field">
        <input type="password" name="password" id="password" placeholder="Contraseña" required />
        <span id="togglePassword" style="cursor: pointer;">👁️</span>
      </div>

      <button type="submit">Entrar</button>
      <p class="login-link">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
    </form>

    <div class="text-center mt-3">
      <a href="../../index.php" class="btn-back">← Volver al inicio</a>
    </div>
  </div>

  <script>
    // Mostrar/ocultar contraseña
    const toggle = document.getElementById("togglePassword");
    const password = document.getElementById("password");
    toggle.addEventListener("click", () => {
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      toggle.textContent = type === "password" ? "👁️" : "🙈";
    });
  </script>
</body>
</html>
