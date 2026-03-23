<?php
require_once __DIR__ . "/../../includes/bootstrap.php";
require_once __DIR__ . "/../../includes/json_response.php";

$id = (int) ($_POST["id"] ?? 0);
$marca = trim($_POST["marca"] ?? "");
$modelo = trim($_POST["modelo"] ?? "");
$precio = trim($_POST["precio"] ?? "");
$idCategoria = (int) ($_POST["id_categoria"] ?? 0);

if ($id <= 0 || $marca === "" || $modelo === "" || $precio === "" || $idCategoria <= 0) {
    jsonResponse(["ok" => false, "mensaje" => "Datos invalidos"], 422);
}

$stmtCategoria = $conn->prepare("SELECT nombre FROM categorias WHERE id_categoria = ?");
$stmtCategoria->bind_param("i", $idCategoria);
$stmtCategoria->execute();
$categoria = $stmtCategoria->get_result()->fetch_assoc();

if (!$categoria) {
    jsonResponse(["ok" => false, "mensaje" => "Categoria invalida"], 422);
}

$stmt = $conn->prepare("UPDATE motos SET marca = ?, modelo = ?, precio = ?, id_categoria = ? WHERE id = ?");
$stmt->bind_param("sssii", $marca, $modelo, $precio, $idCategoria, $id);
$stmt->execute();

jsonResponse([
    "ok" => true,
    "moto" => [
        "id" => $id,
        "marca" => htmlspecialchars($marca, ENT_QUOTES, "UTF-8"),
        "modelo" => htmlspecialchars($modelo, ENT_QUOTES, "UTF-8"),
        "precio" => htmlspecialchars($precio, ENT_QUOTES, "UTF-8"),
        "id_categoria" => $idCategoria,
        "categoria_nombre" => htmlspecialchars($categoria["nombre"], ENT_QUOTES, "UTF-8"),
    ],
]);
