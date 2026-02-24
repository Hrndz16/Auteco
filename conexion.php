<?php
$host = "localhost";
$user = "marlon";
$pass = "1234";
$db   = "autecoDB";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
