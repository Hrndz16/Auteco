<?php
include("../conexion.php");

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(["ok" => false, "mensaje" => "ID inválido"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM motos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode(["ok" => true, "id" => $id]);
