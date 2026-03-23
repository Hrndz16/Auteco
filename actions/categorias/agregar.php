<?php
require_once __DIR__ . "/../../includes/bootstrap.php";
require_once __DIR__ . "/../../includes/json_response.php";

$nombre = trim($_POST["nombre"] ?? "");

if ($nombre === "") {
    jsonResponse(["ok" => false, "mensaje" => "El nombre es obligatorio"], 422);
}

$stmt = $conn->prepare("INSERT INTO categorias (nombre) VALUES (?)");
$stmt->bind_param("s", $nombre);
$stmt->execute();

$categoria = [
    "id_categoria" => $conn->insert_id,
    "nombre" => $nombre,
];

jsonResponse([
    "ok" => true,
    "fila" => renderCategoriaRow($categoria),
    "categoria" => [
        "id_categoria" => $categoria["id_categoria"],
        "nombre" => htmlspecialchars($nombre, ENT_QUOTES, "UTF-8"),
    ],
]);
