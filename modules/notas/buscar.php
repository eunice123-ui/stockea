<?php
session_start();
include '../../includes/db.php';

$usuario_id = $_SESSION["usuario_id"];
$q = "%" . $_GET['q'] . "%";

$stmt = $conn->prepare("SELECT * FROM notas WHERE usuario_id = ? AND (titulo LIKE ? OR contenido LIKE ?) ORDER BY id DESC");
$stmt->bind_param("iss", $usuario_id, $q, $q);
$stmt->execute();
$result = $stmt->get_result();

while ($nota = $result->fetch_assoc()) {
    echo "<div class='col-md-4'>";
    $categoriaColor = [
    "Personal" => "#fef9c3", // amarillo claro
    "Trabajo" => "#c7f0db",  // verde agua
    "Ideas"   => "#dbeafe",  // azul cielo
    "Otro"    => "#f3e8ff"   // violeta
];

$color = $categoriaColor[$nota['categoria']] ?? "#fff";
echo "<div class='nota p-3 rounded' style='background: {$color}'>";

    echo "<h5>" . htmlspecialchars($nota['titulo']) . "</h5>";
    echo "<p>" . nl2br(htmlspecialchars($nota['contenido'])) . "</p>";
    echo "<small class='text-muted'>" . $nota['categoria'] . "</small><br>";
    echo "<a href='editar.php?id={$nota['id']}' class='btn btn-sm btn-outline-primary me-1'><i class='bi bi-pencil'></i></a>";
    echo "<a href='eliminar.php?id={$nota['id']}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"¿Eliminar nota?\")'><i class='bi bi-trash'></i></a>";
    echo "</div></div>";
}
?>
