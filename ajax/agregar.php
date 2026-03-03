<?php
include("../conexion.php");

$marca = trim($_POST['marca'] ?? '');
$modelo = trim($_POST['modelo'] ?? '');
$precio = trim($_POST['precio'] ?? '');
$idCategoria = (int) ($_POST['id_categoria'] ?? 0);

if ($marca === '' || $modelo === '' || $precio === '' || $idCategoria <= 0) {
    echo json_encode(["ok" => false, "mensaje" => "Datos incompletos"]);
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

$stmt = $conn->prepare("INSERT INTO motos (marca, modelo, precio, id_categoria) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $marca, $modelo, $precio, $idCategoria);
$stmt->execute();

$id = $conn->insert_id;

$marcaSafe = htmlspecialchars($marca);
$modeloSafe = htmlspecialchars($modelo);
$precioSafe = htmlspecialchars($precio);
$nombreCategoriaSafe = htmlspecialchars($categoria['nombre']);

$fila = "
<tr id='moto-$id'>
    <td>$id</td>
    <td>$marcaSafe</td>
    <td>$modeloSafe</td>
    <td>$precioSafe</td>
    <td data-id-categoria='$idCategoria'>$nombreCategoriaSafe</td>
    <td class='text-center acciones'>
        <button class='btn btn-sm btn-info text-white btn-ver' data-id='$id'>Ver</button>
        <button class='btn btn-sm btn-warning btn-editar' data-id='$id'>Editar</button>
        <button class='btn btn-sm btn-danger btn-eliminar' data-id='$id'>Eliminar</button>
    </td>
</tr>
";

echo json_encode([
    "ok" => true,
    "fila" => $fila
]);
