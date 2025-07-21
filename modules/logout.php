<?php
session_start();
session_unset();
session_destroy();

// Redirigir a la página principal del proyecto
header("Location: /STOCKEA/index.php");
exit();
