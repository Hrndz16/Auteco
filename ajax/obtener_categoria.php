<?php
include("../conexion.php");

$id = (int) ($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT id_categoria, nombre FROM categorias WHERE id_categoria = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$categoria = $result->fetch_assoc();

if (!$categoria) {
    echo json_encode(["ok" => false, "mensaje" => "Categoría no encontrada"]);
    exit;
}

echo json_encode(["ok" => true, "categoria" => $categoria]);
