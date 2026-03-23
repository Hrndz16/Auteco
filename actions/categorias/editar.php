<?php
require_once __DIR__ . "/../../includes/bootstrap.php";
require_once __DIR__ . "/../../includes/json_response.php";

$id = (int) ($_POST["id_categoria"] ?? 0);
$nombre = trim($_POST["nombre"] ?? "");

if ($id <= 0 || $nombre === "") {
    jsonResponse(["ok" => false, "mensaje" => "Datos invalidos"], 422);
}

$stmt = $conn->prepare("UPDATE categorias SET nombre = ? WHERE id_categoria = ?");
$stmt->bind_param("si", $nombre, $id);
$stmt->execute();

jsonResponse([
    "ok" => true,
    "categoria" => [
        "id_categoria" => $id,
        "nombre" => htmlspecialchars($nombre, ENT_QUOTES, "UTF-8"),
    ],
]);
