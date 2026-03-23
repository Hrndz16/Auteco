<section id="vistaCategorias" class="vista-tabla d-none">
    <div class="table-tools mb-3">
        <input type="text" class="form-control table-search" id="buscarCategorias" placeholder="Buscar en categorias...">
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
                <?php foreach ($categorias as $categoria): ?>
                    <?= renderCategoriaRow($categoria); ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="table-pagination" id="paginacionCategorias"></div>
</section>
