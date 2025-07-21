php
<?php
include '../../includes/db.php';
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

$stmt = $conn->prepare("DELETE FROM eventos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
echo json_encode(["status" => "ok"]);
?>