<div class="modal fade" id="modalAgregarMoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Moto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form id="formAgregarMoto">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="agregarMarca">Marca</label>
                        <input type="text" id="agregarMarca" name="marca" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="agregarModelo">Modelo</label>
                        <input type="text" id="agregarModelo" name="modelo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="agregarPrecio">Precio</label>
                        <input type="number" id="agregarPrecio" name="precio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="agregarIdCategoria">Categoria</label>
                        <select name="id_categoria" class="form-select" required id="agregarIdCategoria">
                            <?= renderCategoriaOptions($categorias); ?>
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

<div class="modal fade" id="modalVerMoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Moto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="verId"></span></p>
                <p><strong>Marca:</strong> <span id="verMarca"></span></p>
                <p><strong>Modelo:</strong> <span id="verModelo"></span></p>
                <p><strong>Precio:</strong> $<span id="verPrecio"></span></p>
                <p><strong>Categoria:</strong> <span id="verCategoria"></span></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarMoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Moto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form id="formEditarMoto">
                <input type="hidden" name="id" id="editId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="editMarca">Marca</label>
                        <input type="text" name="marca" id="editMarca" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="editModelo">Modelo</label>
                        <input type="text" name="modelo" id="editModelo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="editPrecio">Precio</label>
                        <input type="number" name="precio" id="editPrecio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="editIdCategoria">Categoria</label>
                        <select name="id_categoria" id="editIdCategoria" class="form-select" required>
                            <?= renderCategoriaOptions($categorias); ?>
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

<div class="modal fade" id="modalEliminarMoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
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
