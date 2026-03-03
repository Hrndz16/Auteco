<?php
include("../conexion.php");

$id = (int) ($_POST['id'] ?? 0);
$marca = trim($_POST['marca'] ?? '');
$modelo = trim($_POST['modelo'] ?? '');
$precio = trim($_POST['precio'] ?? '');
$idCategoria = (int) ($_POST['id_categoria'] ?? 0);

if ($id <= 0 || $marca === '' || $modelo === '' || $precio === '' || $idCategoria <= 0) {
    echo json_encode(["ok" => false, "mensaje" => "Datos inválidos"]);
    exit;
}

$stmtCategoria = $conn->prepare("SELECT nombre FROM categorias WHERE id_categoria = ?");
$stmtCategoria->bind_param("i", $idCategoria);
$stmtCategoria->execute();
$resCategoria = $stmtCategoria->get_result();
$categoria = $resCategoria->fetch_assoc();

if (!$categoria) {
    echo json_encode(["ok" => false, "mensaje" => "Categoría inválida"]);
    exit;
}

$stmt = $conn->prepare("UPDATE motos SET marca = ?, modelo = ?, precio = ?, id_categoria = ? WHERE id = ?");
$stmt->bind_param("sssii", $marca, $modelo, $precio, $idCategoria, $id);
$stmt->execute();

echo json_encode([
    "ok" => true,
    "moto" => [
        "id" => $id,
        "marca" => htmlspecialchars($marca),
        "modelo" => htmlspecialchars($modelo),
        "precio" => htmlspecialchars($precio),
        "id_categoria" => $idCategoria,
        "categoria_nombre" => htmlspecialchars($categoria['nombre'])
    ]
]);
