<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Motos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Listado de Motos</h2>
        <button class="btn-agregar" data-bs-toggle="modal" data-bs-target="#modalAgregar">
            ➕ Agregar
        </button>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="tablaMotos">
            <?php
            include("conexion.php");
            $res = $conn->query("SELECT * FROM motos");
            while ($row = $res->fetch_assoc()) {
                $id = (int) $row['id'];
                $marca = htmlspecialchars($row['marca']);
                $modelo = htmlspecialchars($row['modelo']);
                $precio = htmlspecialchars($row['precio']);
                echo "
                <tr id='moto-$id'>
                    <td>{$id}</td>
                    <td>{$marca}</td>
                    <td>{$modelo}</td>
                    <td>{$precio}</td>
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

<!-- MODAL AGREGAR -->
<div class="modal fade" id="modalAgregar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Agregar Moto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formAgregar">
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
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-guardar">Guardar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- MODAL VER -->
<div class="modal fade" id="modalVer" tabindex="-1">
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
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Moto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditar">
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
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-guardar">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL ELIMINAR -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Seguro que deseas eliminar esta moto?</p>
                <input type="hidden" id="eliminarId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap + JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/app.js"></script>

</body>
</html>
