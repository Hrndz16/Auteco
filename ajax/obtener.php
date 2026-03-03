<?php
include("../conexion.php");

$id = (int) ($_GET['id'] ?? 0);

$stmt = $conn->prepare(
    "SELECT m.id, m.marca, m.modelo, m.precio, m.id_categoria, c.nombre AS categoria_nombre
     FROM motos m
     INNER JOIN categorias c ON c.id_categoria = m.id_categoria
     WHERE m.id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$moto = $result->fetch_assoc();

if (!$moto) {
    echo json_encode(["ok" => false, "mensaje" => "Moto no encontrada"]);
    exit;
}

echo json_encode(["ok" => true, "moto" => $moto]);
