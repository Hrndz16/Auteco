<?php
include("../conexion.php");

$id = (int) ($_POST['id'] ?? 0);
$marca = trim($_POST['marca'] ?? '');
$modelo = trim($_POST['modelo'] ?? '');
$precio = trim($_POST['precio'] ?? '');

if ($id <= 0 || $marca === '' || $modelo === '' || $precio === '') {
    echo json_encode(["ok" => false, "mensaje" => "Datos inválidos"]);
    exit;
}

$stmt = $conn->prepare("UPDATE motos SET marca = ?, modelo = ?, precio = ? WHERE id = ?");
$stmt->bind_param("sssi", $marca, $modelo, $precio, $id);
$stmt->execute();

echo json_encode([
    "ok" => true,
    "moto" => [
        "id" => $id,
        "marca" => htmlspecialchars($marca),
        "modelo" => htmlspecialchars($modelo),
        "precio" => htmlspecialchars($precio),
    ]
]);
