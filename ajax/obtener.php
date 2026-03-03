<?php
include("../conexion.php");

$id = (int) ($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT id, marca, modelo, precio FROM motos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$moto = $result->fetch_assoc();

if (!$moto) {
    echo json_encode(["ok" => false, "mensaje" => "Moto no encontrada"]);
    exit;
}

echo json_encode(["ok" => true, "moto" => $moto]);
