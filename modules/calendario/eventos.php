<?php
header('Content-Type: application/json');

$eventos = [
    [
        "title" => "📦 Inventario mensual",
        "start" => date("Y-m-d"),
        "descripcion" => "Verificar stock general",
        "color" => "#40916c"
    ],
    [
        "title" => "📝 Reunión con proveedor",
        "start" => date("Y-m-d", strtotime("+3 days")),
        "descripcion" => "Negociar nuevos precios",
        "color" => "#f9c74f"
    ]
];

echo json_encode($eventos);
