<?php
require_once __DIR__ . "/../../includes/bootstrap.php";
require_once __DIR__ . "/../../includes/json_response.php";

$marca = trim($_POST["marca"] ?? "");
$modelo = trim($_POST["modelo"] ?? "");
$precio = trim($_POST["precio"] ?? "");
$idCategoria = (int) ($_POST["id_categoria"] ?? 0);

if ($marca === "" || $modelo === "" || $precio === "" || $idCategoria <= 0) {
    jsonResponse(["ok" => false, "mensaje" => "Datos incompletos"], 422);
}

// Antes de insertar, se valida que la categoria exista para mantener consistencia.
$stmtCategoria = $conn->prepare("SELECT nombre FROM categorias WHERE id_categoria = ?");
$stmtCategoria->bind_param("i", $idCategoria);
$stmtCategoria->execute();
$categoria = $stmtCategoria->get_result()->fetch_assoc();

if (!$categoria) {
    jsonResponse(["ok" => false, "mensaje" => "Categoria invalida"], 422);
}

$stmt = $conn->prepare("INSERT INTO motos (marca, modelo, precio, id_categoria) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $marca, $modelo, $precio, $idCategoria);
$stmt->execute();

$moto = [
    "id" => $conn->insert_id,
    "marca" => $marca,
    "modelo" => $modelo,
    "precio" => $precio,
    "id_categoria" => $idCategoria,
    "categoria_nombre" => $categoria["nombre"],
];

jsonResponse([
    "ok" => true,
    "fila" => renderMotoRow($moto),
]);
