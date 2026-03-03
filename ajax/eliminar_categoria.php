<?php
include("../conexion.php");

$id = (int) ($_POST['id_categoria'] ?? 0);

if ($id <= 0) {
    echo json_encode(["ok" => false, "mensaje" => "ID inválido"]);
    exit;
}

$stmtValidar = $conn->prepare("SELECT COUNT(*) AS total FROM motos WHERE id_categoria = ?");
$stmtValidar->bind_param("i", $id);
$stmtValidar->execute();
$resValidar = $stmtValidar->get_result();
$dataValidar = $resValidar->fetch_assoc();

if ((int) $dataValidar['total'] > 0) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No se puede eliminar la categoría porque tiene motos asociadas"
    ]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM categorias WHERE id_categoria = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode(["ok" => true, "id_categoria" => $id]);
