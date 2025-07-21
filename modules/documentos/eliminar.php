<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../modules/login/login.php");
    exit();
}

if (isset($_GET['file'])) {
    $archivo = "../../assets/uploads/" . basename($_GET['file']);
    if (file_exists($archivo)) {
        unlink($archivo);
    }
}

header("Location: index.php");
