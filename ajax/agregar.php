<?php
include("../conexion.php");

$marca  = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];

$conn->query("INSERT INTO motos (marca, modelo, precio)
              VALUES ('$marca', '$modelo', '$precio')");

$id = $conn->insert_id;

echo json_encode([
    "ok" => true,
    "fila" => "
        <tr>
            <td>$id</td>
            <td>$marca</td>
            <td>$modelo</td>
            <td>$precio</td>
        </tr>
    "
]);