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

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody id="tablaMotos">
            <?php
            include("conexion.php");
            $res = $conn->query("SELECT * FROM motos");
            while ($row = $res->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['marca']}</td>
                    <td>{$row['modelo']}</td>
                    <td>{$row['precio']}</td>
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

<!-- Bootstrap + JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/app.js"></script>

</body>
</html>