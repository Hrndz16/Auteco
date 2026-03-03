<?php
include("../conexion.php");

$id = (int) ($_POST['id_categoria'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');

if ($id <= 0 || $nombre === '') {
    echo json_encode(["ok" => false, "mensaje" => "Datos inválidos"]);
    exit;
}

$stmt = $conn->prepare("UPDATE categorias SET nombre = ? WHERE id_categoria = ?");
$stmt->bind_param("si", $nombre, $id);
$stmt->execute();

echo json_encode([
    "ok" => true,
    "categoria" => [
        "id_categoria" => $id,
        "nombre" => htmlspecialchars($nombre)
    ]
]);
