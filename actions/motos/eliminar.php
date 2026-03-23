<?php
require_once __DIR__ . "/../../includes/bootstrap.php";
require_once __DIR__ . "/../../includes/json_response.php";

$id = (int) ($_POST["id"] ?? 0);

if ($id <= 0) {
    jsonResponse(["ok" => false, "mensaje" => "ID invalido"], 422);
}

$stmt = $conn->prepare("DELETE FROM motos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

jsonResponse([
    "ok" => true,
    "id" => $id,
]);
