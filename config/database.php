<?php
// Conexion unica a la base de datos para reutilizarla en toda la aplicacion.
$host = getenv("DB_HOST") ?: "localhost";
$user = getenv("DB_USER") ?: "root";
$pass = getenv("DB_PASS") ?: "";
$db = getenv("DB_NAME") ?: "autecoDB";
$port = (int) (getenv("DB_PORT") ?: 3306);

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Error de conexion: " . $conn->connect_error);
}
