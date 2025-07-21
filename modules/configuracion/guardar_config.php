<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modo = $_POST['modo'] ?? 'claro';
    $fuente = $_POST['fuente'] ?? 'normal';

    $_SESSION['preferencias'] = [
        'modo' => $modo,
        'fuente' => $fuente
    ];

    header("Location: index.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
