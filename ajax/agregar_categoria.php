<?php
include("../conexion.php");

$nombre = trim($_POST['nombre'] ?? '');

if ($nombre === '') {
    echo json_encode(["ok" => false, "mensaje" => "El nombre es obligatorio"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO categorias (nombre) VALUES (?)");
$stmt->bind_param("s", $nombre);
$stmt->execute();

$id = $conn->insert_id;
$nombreSafe = htmlspecialchars($nombre);

$fila = "
<tr id='categoria-$id'>
    <td>$id</td>
    <td>$nombreSafe</td>
    <td class='text-center acciones'>
        <button class='btn btn-sm btn-info text-white btn-ver-categoria' data-id='$id'>Ver</button>
        <button class='btn btn-sm btn-warning btn-editar-categoria' data-id='$id'>Editar</button>
        <button class='btn btn-sm btn-danger btn-eliminar-categoria' data-id='$id'>Eliminar</button>
    </td>
</tr>
";

echo json_encode([
    "ok" => true,
    "fila" => $fila,
    "categoria" => [
        "id_categoria" => $id,
        "nombre" => $nombreSafe
    ]
]);
