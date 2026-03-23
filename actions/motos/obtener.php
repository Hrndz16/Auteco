<?php
require_once __DIR__ . "/../../includes/bootstrap.php";
require_once __DIR__ . "/../../includes/json_response.php";

$id = (int) ($_GET["id"] ?? 0);

if ($id <= 0) {
    jsonResponse(["ok" => false, "mensaje" => "ID invalido"], 422);
}

$stmt = $conn->prepare(
    "SELECT m.id, m.marca, m.modelo, m.precio, m.id_categoria, c.nombre AS categoria_nombre
     FROM motos m
     INNER JOIN categorias c ON c.id_categoria = m.id_categoria
     WHERE m.id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$moto = $stmt->get_result()->fetch_assoc();

if (!$moto) {
    jsonResponse(["ok" => false, "mensaje" => "Moto no encontrada"], 404);
}

jsonResponse([
    "ok" => true,
    "moto" => $moto,
]);
