<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Motos y Categorías</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
<?php
include("conexion.php");

$categorias = [];
$resCategorias = $conn->query("SELECT id_categoria, nombre FROM categorias ORDER BY id_categoria ASC");
while ($row = $resCategorias->fetch_assoc()) {
    $categorias[] = $row;
}
?>

<div class="layout-app">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5 class="mb-0">Panel</h5>
            <button class="btn btn-sm btn-light d-lg-none" id="cerrarSidebar">✕</button>
        </div>
        <nav class="menu-lateral mt-3">
            <button class="menu-item active" data-tab="motos">🏍️ Tabla de Motos</button>
            <button class="menu-item" data-tab="categorias">📂 Tabla de Categorías</button>
        </nav>
    </aside>

    <main class="contenido-principal">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-outline-primary d-lg-none" id="abrirSidebar">☰ Menú</button>
            <h2 id="tituloVista" class="mb-0">Listado de Motos</h2>
            <div>
                <button class="btn-agregar" id="btnAgregarMoto" data-bs-toggle="modal" data-bs-target="#modalAgregarMoto">➕ Agregar Moto</button>
                <button class="btn-agregar d-none" id="btnAgregarCategoria" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria">➕ Agregar Categoría</button>
            </div>
        </div>

        <section id="vistaMotos" class="vista-tabla">
            <div class="table-tools mb-3">
                <input type="text" class="form-control table-search" id="buscarMotos" placeholder="Buscar en motos...">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="tablaMotosListado">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Precio</th>
                            <th>Categoría</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaMotos">
                        <?php
                        $resMotos = $conn->query(
                            "SELECT m.id, m.marca, m.modelo, m.precio, m.id_categoria, c.nombre AS categoria_nombre
                             FROM motos m
                             INNER JOIN categorias c ON c.id_categoria = m.id_categoria
                             ORDER BY m.id ASC"
                        );

                        while ($row = $resMotos->fetch_assoc()) {
                            $id = (int) $row['id'];
                            $marca = htmlspecialchars($row['marca']);
                            $modelo = htmlspecialchars($row['modelo']);
                            $precio = htmlspecialchars($row['precio']);
                            $idCategoria = (int) $row['id_categoria'];
                            $categoriaNombre = htmlspecialchars($row['categoria_nombre']);
                            echo "
                            <tr id='moto-$id'>
                                <td>{$id}</td>
                                <td>{$marca}</td>
                                <td>{$modelo}</td>
                                <td>{$precio}</td>
                                <td data-id-categoria='{$idCategoria}'>{$categoriaNombre}</td>
                                <td class='text-center acciones'>
                                    <button class='btn btn-sm btn-info text-white btn-ver' data-id='{$id}'>Ver</button>
                                    <button class='btn btn-sm btn-warning btn-editar' data-id='{$id}'>Editar</button>
                                    <button class='btn btn-sm btn-danger btn-eliminar' data-id='{$id}'>Eliminar</button>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="table-pagination" id="paginacionMotos"></div>
        </section>

        <section id="vistaCategorias" class="vista-tabla d-none">
            <div class="table-tools mb-3">
                <input type="text" class="form-control table-search" id="buscarCategorias" placeholder="Buscar en categorías...">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="tablaCategoriasListado">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaCategorias">
                        <?php foreach ($categorias as $categoria) : ?>
                            <tr id="categoria-<?php echo (int) $categoria['id_categoria']; ?>">
                                <td><?php echo (int) $categoria['id_categoria']; ?></td>
                                <td><?php echo htmlspecialchars($categoria['nombre']); ?></td>
                                <td class="text-center acciones">
                                    <button class="btn btn-sm btn-info text-white btn-ver-categoria" data-id="<?php echo (int) $categoria['id_categoria']; ?>">Ver</button>
                                    <button class="btn btn-sm btn-warning btn-editar-categoria" data-id="<?php echo (int) $categoria['id_categoria']; ?>">Editar</button>
                                    <button class="btn btn-sm btn-danger btn-eliminar-categoria" data-id="<?php echo (int) $categoria['id_categoria']; ?>">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-pagination" id="paginacionCategorias"></div>
        </section>
    </main>
</div>

<!-- MODAL AGREGAR MOTO -->
<div class="modal fade" id="modalAgregarMoto" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Moto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formAgregarMoto">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Marca</label>
                        <input type="text" name="marca" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Modelo</label>
                        <input type="text" name="modelo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Precio</label>
                        <input type="number" name="precio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Categoría</label>
                        <select name="id_categoria" class="form-select" required id="agregarIdCategoria">
                            <option value="">Selecciona una categoría</option>
                            <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?php echo (int) $categoria['id_categoria']; ?>"><?php echo htmlspecialchars($categoria['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL VER MOTO -->
<div class="modal fade" id="modalVerMoto" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Moto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="verId"></span></p>
                <p><strong>Marca:</strong> <span id="verMarca"></span></p>
                <p><strong>Modelo:</strong> <span id="verModelo"></span></p>
                <p><strong>Precio:</strong> $<span id="verPrecio"></span></p>
                <p><strong>Categoría:</strong> <span id="verCategoria"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDITAR MOTO -->
<div class="modal fade" id="modalEditarMoto" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Moto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditarMoto">
                <input type="hidden" name="id" id="editId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Marca</label>
                        <input type="text" name="marca" id="editMarca" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Modelo</label>
                        <input type="text" name="modelo" id="editModelo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Precio</label>
                        <input type="number" name="precio" id="editPrecio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Categoría</label>
                        <select name="id_categoria" id="editIdCategoria" class="form-select" required>
                            <option value="">Selecciona una categoría</option>
                            <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?php echo (int) $categoria['id_categoria']; ?>"><?php echo htmlspecialchars($categoria['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-guardar">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL ELIMINAR MOTO -->
<div class="modal fade" id="modalEliminarMoto" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Seguro que deseas eliminar esta moto?</p>
                <input type="hidden" id="eliminarMotoId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarMoto">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODALES CATEGORÍAS -->
<div class="modal fade" id="modalAgregarCategoria" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formAgregarCategoria">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVerCategoria" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="verCategoriaId"></span></p>
                <p><strong>Nombre:</strong> <span id="verCategoriaNombre"></span></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarCategoria" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarCategoria">
                <input type="hidden" name="id_categoria" id="editCategoriaId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="editCategoriaNombre" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-guardar">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEliminarCategoria" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Seguro que deseas eliminar esta categoría?</p>
                <input type="hidden" id="eliminarCategoriaId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarCategoria">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
