<?php
require_once __DIR__ . "/../../includes/bootstrap.php";
require_once __DIR__ . "/../../includes/json_response.php";

$id = (int) ($_POST["id_categoria"] ?? 0);

if ($id <= 0) {
    jsonResponse(["ok" => false, "mensaje" => "ID invalido"], 422);
}

// Se protege la integridad referencial evitando borrar categorias con motos asociadas.
$stmtValidar = $conn->prepare("SELECT COUNT(*) AS total FROM motos WHERE id_categoria = ?");
$stmtValidar->bind_param("i", $id);
$stmtValidar->execute();
$dataValidar = $stmtValidar->get_result()->fetch_assoc();

if ((int) $dataValidar["total"] > 0) {
    jsonResponse([
        "ok" => false,
        "mensaje" => "No se puede eliminar la categoria porque tiene motos asociadas",
    ], 409);
}

$stmt = $conn->prepare("DELETE FROM categorias WHERE id_categoria = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

jsonResponse([
    "ok" => true,
    "id_categoria" => $id,
]);
