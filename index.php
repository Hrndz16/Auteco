<?php
require_once __DIR__ . "/includes/bootstrap.php";

// Se cargan una vez los datos necesarios para construir la interfaz inicial.
$categorias = [];
$resCategorias = $conn->query("SELECT id_categoria, nombre FROM categorias ORDER BY id_categoria ASC");
while ($row = $resCategorias->fetch_assoc()) {
    $categorias[] = $row;
}

$motos = [];
$resMotos = $conn->query(
    "SELECT m.id, m.marca, m.modelo, m.precio, m.id_categoria, c.nombre AS categoria_nombre
     FROM motos m
     INNER JOIN categorias c ON c.id_categoria = m.id_categoria
     ORDER BY m.id ASC"
);
while ($row = $resMotos->fetch_assoc()) {
    $motos[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Motos y Categorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <div class="layout-app">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h5 class="mb-0">Panel</h5>
                <button class="btn btn-sm btn-light d-lg-none" id="cerrarSidebar">X</button>
            </div>
            <nav class="menu-lateral mt-3">
                <button class="menu-item active" data-tab="motos">Tabla de Motos</button>
                <button class="menu-item" data-tab="categorias">Tabla de Categorias</button>
            </nav>
        </aside>

        <main class="contenido-principal">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-outline-primary d-lg-none" id="abrirSidebar">Menu</button>
                <h2 id="tituloVista" class="mb-0">Listado de Motos</h2>
                <div>
                    <button class="btn-agregar" id="btnAgregarMoto" data-bs-toggle="modal" data-bs-target="#modalAgregarMoto">+ Agregar Moto</button>
                    <button class="btn-agregar d-none" id="btnAgregarCategoria" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria">+ Agregar Categoria</button>
                </div>
            </div>

            <?php require __DIR__ . "/views/sections/motos.php"; ?>
            <?php require __DIR__ . "/views/sections/categorias.php"; ?>
        </main>
    </div>

    <?php require __DIR__ . "/views/modals/motos.php"; ?>
    <?php require __DIR__ . "/views/modals/categorias.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
