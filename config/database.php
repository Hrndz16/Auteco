<?php
// Conexion unica a la base de datos para reutilizarla en toda la aplicacion.
$host = "localhost";
$user = "root";
$pass = "";
$db = "autecoDB";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexion: " . $conn->connect_error);
}
