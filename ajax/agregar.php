<?php
include("../conexion.php");

$marca = trim($_POST['marca'] ?? '');
$modelo = trim($_POST['modelo'] ?? '');
$precio = trim($_POST['precio'] ?? '');

if ($marca === '' || $modelo === '' || $precio === '') {
    echo json_encode(["ok" => false, "mensaje" => "Datos incompletos"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO motos (marca, modelo, precio) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $marca, $modelo, $precio);
$stmt->execute();

$id = $conn->insert_id;

$marcaSafe = htmlspecialchars($marca);
$modeloSafe = htmlspecialchars($modelo);
$precioSafe = htmlspecialchars($precio);

$fila = "
<tr id='moto-$id'>
    <td>$id</td>
    <td>$marcaSafe</td>
    <td>$modeloSafe</td>
    <td>$precioSafe</td>
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
