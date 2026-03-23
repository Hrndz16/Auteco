<?php
require_once __DIR__ . "/../../includes/bootstrap.php";
require_once __DIR__ . "/../../includes/json_response.php";

$id = (int) ($_GET["id"] ?? 0);

if ($id <= 0) {
    jsonResponse(["ok" => false, "mensaje" => "ID invalido"], 422);
}

$stmt = $conn->prepare("SELECT id_categoria, nombre FROM categorias WHERE id_categoria = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$categoria = $stmt->get_result()->fetch_assoc();

if (!$categoria) {
    jsonResponse(["ok" => false, "mensaje" => "Categoria no encontrada"], 404);
}

jsonResponse([
    "ok" => true,
    "categoria" => $categoria,
]);
